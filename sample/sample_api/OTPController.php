<?php

namespace App\Http\Controllers\SMS;

use App\Http\Controllers\ApplicationController;

use App\Services\SMS\SMSServiceInterface;
use App\Services\OTP\OTPServiceInterface;
use App\Services\Notification\ErrorNotificationServiceInterface;
use App\Services\Validation\ValidationServiceInterface;
use App\Services\Users\UserServiceInterface;

class OTPController extends ApplicationController
{
    private $sms_service;
    private $otp_service;
    private $error_notification;
    private $validation_service;
    private $user_service;

    const OTP_FILTER = [
        'phone_number'  => 'trim|escape',
        'iso_code'      => 'trim|escape|uppercase',
        'type'          => 'trim|escape|uppercase',
        'otp_code'      => 'trim|escape|digit'
    ];
    const OTP_TYPE_VALIDATOR = 'required|string';
    const OTP_PIN_VALIDATOR = 'required|digits:4';

    public function __construct(SMSServiceInterface $sms_service, OTPServiceInterface $otp_service, ErrorNotificationServiceInterface $error_notification, ValidationServiceInterface $validation_service, UserServiceInterface $user_service)
    {
        parent::__construct();

        $this->middleware('auth:api', ['except' => ['sendOTP', 'validateOTP']]);

        $this->sms = $sms_service;
        $this->otp = $otp_service;
        $this->slack = $error_notification;
        $this->validation = $validation_service;
        $this->user = $user_service;
    }

    /**
     * Set SMS body template with pin
     * @param String pin
     * @return String $sms_message
     */
    protected function generateOTPMessage($pin) : String
    {
        $sms_message = $this->validation->getValidationMessage('mobile', 'sms_otp', true, 'body');
        $sms_message = str_replace('$pin', $pin, $sms_message);
        $sms_message = str_replace('$app_name', env('APP_NAME'), $sms_message);

        return $sms_message;
    }

    /**
     * Set OTP Action based on type
     * @param String $type
     * @return Array message & data
     */
    protected function setOTPAction($type, $phone_number) : array
    {
        switch($type) {
            case 'ACCOUNT_ACTIVATION' : 
                // activate user
                $user = $this->user->getUserByPhoneNumber($phone_number);
                $user->is_active = true;
                $user->save();

                // get jwt token for login
                $token = app(\App\Http\Controllers\Auth\AuthController::class)->loginByUser($user);

                // get full profile for return login
                $user_profile = $this->user->getFullProfile(auth()->user()->user_id);

                if ($user_profile['user_role'] == null) {
                    $status_code = 400;
                    $message = $this->validation->getValidationMessage('mobile', 'login', false, 'role');
                    $data = null;
                } else {
                    $status_code = 200;
                    $message = $this->validation->getValidationMessage('mobile', 'login', true, 'success');
                    $data = $user_profile;
                }
            break;
            default :
                $status_code = 200;
                $message = 'Valid';
                $data = null;
        }

        return [
            'status_code' => $status_code,
            'message' => $message,
            'data' => $data
        ];
    }

    /**
     * Send SMS with OTP Code that is valid for 10 minutes
     * @param String phone_number - can be in any format, but E164 is recommended
     * @param String iso_code - e.g. ID, MY, SG, etc
     * @param String type - what this otp is used for. e.g. account_activation, registration, etc
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendOTP()
    {
        $request = request(['phone_number', 'iso_code', 'type']);

        // sanitize input
        $input = $this->validation->sanitizeData($request, self::OTP_FILTER);
        
        // prepare data
        $phone_number = isset($input['phone_number']) ? $input['phone_number'] : null;
        $iso_code = isset($input['iso_code']) ? $input['iso_code'] : null;
        $type = isset($input['type']) ? $input['type'] : null;

        // do validation
        $phone_validator = $this->validation->validatePhoneNumber($phone_number, $iso_code);
        $validator = $this->validation->doValidation($input, ['type' => self::OTP_TYPE_VALIDATOR]);

        if ($phone_validator['status_code'] == 200 && !$validator->fails()) {
            // generate 4 digits pin for OTP
            $pin = $this->otp->generateOTPCode($phone_validator['data']['phone_number_iso'], $type);

            if (is_numeric($pin)) {
                // set the text message in table validation_messages
                $sms_message = $this->generateOTPMessage($pin);

                // send sms api
                $sms = $this->sms->sendSMS($sms_message, $phone_validator['data']['phone_number_iso'], $phone_validator['data']['iso_code']);
                // save sms otp transaction
                $this->otp->storeOTPTransaction($pin, $phone_validator['data']['phone_number_iso'], $type, $sms, $sms->data->messages[0]->status);

                // check api return
                if ($sms->http_code == 200 && $sms->data->messages[0]->status == 'SUCCESS') {
                    $status_code = 200;
                    $message = $this->validation->getValidationMessage('mobile', 'sms_otp', true, 'send');
                } else {
                    $status_code = 400;
                    if ($sms->data->messages[0]->status == 'INVALID_RECIPIENT') {
                        $message = $this->validation->getValidationMessage('mobile', 'phone_number', false, 'valid');
                    } else {
                        $message = $this->validation->getValidationMessage('mobile', 'sms_otp', false, 'send');
                    }
                    
                    // send error notification
                    $this->slack->notify('SMS OTP', json_encode($input), json_encode($sms));
                }
            } else {
                $status_code = 400;
                $message = $this->validation->getValidationMessage('mobile', 'sms_otp', false, 'send');

                // send error notification
                $this->slack->notify('SMS OTP', json_encode($input), json_encode($pin));
            }
        } else {
            $status_code = 400;
            $message = ($validator->fails()) ? $validator->errors()->first() : $phone_validator['message'];
        }

        return $this->reply($status_code, $message, null, $request, __FUNCTION__);
    }

    /**
     * Check whether OTP code is correct or not
     * @param String phone_number - can be in any format, but E164 is recommended
     * @param String iso_code - e.g. ID, MY, SG, etc
     * @param String type - what this otp is used for. e.g. account_activation, registration, etc
     * @param String pin - otp_code
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateOTP()
    {
        $request = request(['phone_number', 'iso_code', 'type', 'pin']);

        // sanitize input
        $input = $this->validation->sanitizeData($request, self::OTP_FILTER);

        // prepare data
        $phone_number = isset($input['phone_number']) ? $input['phone_number'] : null;
        $iso_code = isset($input['iso_code']) ? $input['iso_code'] : null;
        $type = isset($input['type']) ? $input['type'] : null;
        $pin = isset($input['pin']) ? $input['pin'] : null;

        // do validation
        $phone_validator = $this->validation->validatePhoneNumber($phone_number, $iso_code);
        $validator = $this->validation->doValidation($input, ['type' => self::OTP_TYPE_VALIDATOR, 'pin' => self::OTP_PIN_VALIDATOR]);

        if ($phone_validator['status_code'] == 200 && !$validator->fails()) {
            // check otp validity
            $is_otp_valid = $this->otp->checkOTPValidity($pin, $phone_validator['data']['phone_number_iso'], $type);

            if ($is_otp_valid) {
                // invalidate otp
                $otp = $this->otp->invalidateOTP($pin, $phone_validator['data']['phone_number_iso'], $type);

                if ($otp == 'Valid') {
                    $otp_action = self::setOTPAction($type, $phone_validator['data']['phone_number_iso']);
                    $status_code = $otp_action['status_code'];
                    $message = $otp_action['message'];
                    $data = $otp_action['data'];
                } else {
                    $status_code = 400;
                    $message = $this->validation->getValidationMessage('mobile', 'try_again', false, 'retry');
                    $data = null;

                    // send error notification
                    $this->slack->notify('Validate SMS OTP', json_encode($input), json_encode($otp));
                }
            } else {
                $status_code = 400;
                $message = $this->validation->getValidationMessage('mobile', 'sms_otp', false, 'invalid');
                $data = null;
            }
        } else {
            $status_code = 400;
            $message = ($validator->fails()) ? $validator->errors()->first() : $phone_validator['message'];
            $data = null;
        }

        return $this->reply($status_code, $message, $data, $request, __FUNCTION__);
    }
}
