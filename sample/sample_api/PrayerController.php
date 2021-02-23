<?php

namespace App\Http\Controllers\Prayer;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Validator;
use DB;
use JWTAuth;

use App\Models\Prayer\Prayer;
use App\Models\Prayer\PrayerCategory;

use App\Models\Users\UserTransact;
use App\Models\Users\UserInbox;

use App\Models\Feature\Feature;
use App\Models\Feature\FeatureList;

use App\Models\General\Validation;
use App\Services\DeepLink\DeepLinkInterface;
use Illuminate\Support\Facades\Log;
use stdClass;

class PrayerController extends Controller
{
    public function __construct(DeepLinkInterface $deepLink)
    {
        parent::__construct();

        // Prayer
        $this->prayer = new Prayer;

        // Users
        $this->user_transact = new UserTransact;
        $this->user_inbox = new UserInbox;

        // Feature
        $this->feature = new Feature;
        $this->feature_list = new FeatureList;

        // Validation
        $this->validation = new Validation;

        //Deep LInk
        $this->deepLink = $deepLink;
    }

    public function getPrayerCategory(Request $request)
    {
        $category = PrayerCategory::all();
        // get prayer category lists
        $status = true;
        $message = FETCH_SUCCESS;
        $data = ['category' => $category];
        return $this->reply($status, $message, $data, $request, __FUNCTION__);
    }

    /**
     *
     * to submit saved prayer request(s)
     * will try to insert all request(s)
     *
     * @param Array lists
     **** @param Int reference_id
     **** @param Int category_id
     **** @param String description
     *
     */
    public function submitPrayerRequest(Request $request)
    {
        $data = null;
        $user_id = $this->extractJWT($request);
        $type = 'Prayer Request';

        $type_id = $this->feature_list->getId($type);
        $type_show_as = $this->feature->getShowAs($type_id);

        $i = 0;
        $flag = false;
        $prayer_id = null;

        try {
            DB::beginTransaction();
            // loop every prayer request(s)
            if (count($request->lists) > 0) {
                foreach ($request->lists as $prayer) {
                    if (isset($prayer['reference_id'])) {
                        $reference_id = $prayer['reference_id'];
                    } else {
                        $reference_id = null;
                    }

                    // insert each prayer into table
                    $prayer_id = Prayer::create([
                        'user_id' => $user_id,
                        'types' => $type,
                        'type_show_as' => $type_show_as,
                        'category_id' => $prayer['category_id'],
                        'description' => $prayer['description'],
                        'reference_id' => $reference_id,
                        'is_praised' => false
                    ])->id;
                    // reference_id refer to the id that relates to prayer->praise and praise->prayer
                    // if reference_id is set, meaning relationship is created
                    // update prayer table to connect between id and reference_id
                    if (isset($prayer['reference_id']) && $prayer['reference_id'] != null) {
                        Prayer::where('id', $prayer['reference_id'])
                            ->update([
                                'is_praised' => true,
                                'reference_id' => $prayer_id
                            ]);
                    }
                    $i++;
                }
                $status = true;
                $message = $this->validation->getValidationMessage('mobile', 'prayer', true, 'success');
                $msgInbox = 'You just submitted '.$i.' '.strtolower($type_show_as).'(s)';
                $data = [
                    'lists' => $request->lists
                ];
            } else {
                $status = false;
                $message = 'Empty request!';
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->sendErrorNotificationToSlack('Prayer Request', json_encode($request), json_encode('Failed to submit prayer request'. $e->getMessage()));
            $status = false;
            $message = TRY_AGAIN_MSG;
        }

        // insert to user transact
        $transact = $this->user_transact->insertTransact($user_id, null, json_encode(['lists' => $request->lists]), USER_PRAYER_REQUEST);

        if ($status == true) {
            $deep_link_id = null;
            $dataContent = [];
            $deep_link = $this->deepLink->generateLink('prayer/history', $dataContent);
            if($deep_link['deep_link']) {
                $inputDeepLink = new stdClass;
                $inputDeepLink->dynamic_link = $deep_link['deep_link'];
                $inputDeepLink->local_link = $deep_link['link'];
                $my_prayer = Prayer::where('id', $prayer_id)->first();
                $newDeepLink = $this->deepLink->createorupdate($inputDeepLink);
                if($newDeepLink['status_code']==200)
                    $my_prayer->deep_link_id = $newDeepLink['id'];
                $deep_link_id = $my_prayer->deep_link_id;
                $my_prayer->save();
            }

            // insert to user inbox
            $inbox = $this->user_inbox->insertInbox($user_id, $type, $transact['id'], $type_show_as, $msgInbox, false, $type_show_as, $deep_link_id);
        }
        return $this->reply($status, $message, $data, $request, __FUNCTION__);
    }

    /**
     *
     * to submit saved praise report(s)
     * will try to insert all report(s)
     *
     * @param Array lists
     **** @param Int reference_id
     **** @param Int category_id
     **** @param String description
     *
     */
    public function submitPraiseReport(Request $request)
    {
        $data = null;
        $user_id = $this->extractJWT($request);
        $type = 'Praise Report';

        $type_id = $this->feature_list->getId($type);
        $type_show_as = $this->feature->getShowAs($type_id);

        $i = 0;
        $flag = false;
        $prayer_id = null;

        try {
            DB::beginTransaction();
            // loop every prayer request(s)
            if (count($request->lists) > 0) {
                foreach ($request->lists as $prayer) {
                    if (isset($prayer['reference_id'])) {
                        $reference_id = $prayer['reference_id'];
                    } else {
                        $reference_id = null;
                    }

                    // insert each prayer into table
                    $prayer_id = Prayer::create([
                        'user_id' => $user_id,
                        'types' => $type,
                        'type_show_as' => $type_show_as,
                        'category_id' => $prayer['category_id'],
                        'description' => $prayer['description'],
                        'reference_id' => $reference_id,
                        'is_praised' => false
                    ])->id;
                    // reference_id refer to the id that relates to prayer->praise and praise->prayer
                    // if reference_id is set, meaning relationship is created
                    // update prayer table to connect between id and reference_id
                    if (isset($prayer['reference_id']) && $prayer['reference_id'] != null) {
                        Prayer::where('id', $prayer['reference_id'])
                            ->update([
                                'is_praised' => true,
                                'reference_id' => $prayer_id
                            ]);
                    }
                    $i++;
                }
                $status = true;
                $message = $this->validation->getValidationMessage('mobile', 'praise', true, 'success');
                $msgInbox = 'You just submitted '.$i.' '.strtolower($type_show_as).'(s)';
                $data = [
                    'lists' => $request->lists
                ];
            } else {
                $status = false;
                $message = 'Empty request!';
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->sendErrorNotificationToSlack('Praise Request', json_encode($request), json_encode('Failed to submit praise request'. $e->getMessage()));
            $status = false;
            $message = TRY_AGAIN_MSG;
        }

        // insert to user transact
        $transact = $this->user_transact->insertTransact($user_id, null, json_encode(['lists' => $request->lists]), USER_PRAYER_REQUEST);

        if ($status == true) {
            $deep_link_id = null;
            $dataContent = [];
            $deep_link = $this->deepLink->generateLink('praise/history', $dataContent);
            if($deep_link['deep_link']) {
                $inputDeepLink = new stdClass;
                $inputDeepLink->dynamic_link = $deep_link['deep_link'];
                $inputDeepLink->local_link = $deep_link['link'];
                $my_praise = Prayer::where('id', $prayer_id)->first();
                $newDeepLink = $this->deepLink->createorupdate($inputDeepLink);
                if($newDeepLink['status_code']==200)
                    $my_praise->deep_link_id = $newDeepLink['id'];
                $deep_link_id = $my_praise->deep_link_id;
                $my_praise->save();
            }

            // insert to user inbox
            $inbox = $this->user_inbox->insertInbox($user_id, $type, $transact['id'], $type_show_as, $msgInbox, false, $type_show_as, $deep_link_id);
        }
        return $this->reply($status, $message, $data, $request, __FUNCTION__);
    }

    /**
     *
     * to get prayer list
     * or maybe called as prayer history list
     *
     */
    public function getPrayerLists(Request $request)
    {
        // get user_id from token
        $user_id = $this->extractJWT($request);

        $type = 'Prayer Request';

        $prayerList = $this->prayer->getLists($user_id, $type);

        if (count($prayerList) == 0) {
            $status = true;
            $message = NO_DATA;
            $data = null;
        } else {
            $status = true;
            $message = FETCH_SUCCESS;
            $data = $prayerList->items();
        }

        $data = ['lists' => $data];
        return $this->reply($status, $message, $data, $request, __FUNCTION__);
    }

    /**
     *
     * to get praise list
     * or maybe called as praise history list
     *
     */
    public function getPraiseLists(Request $request)
    {
        // get user_id from token
        $user_id = $this->extractJWT($request);

        $type = 'Praise Report';

        $prayerList = $this->prayer->getLists($user_id, $type);

        if (count($prayerList) == 0) {
            $status = true;
            $message = NO_DATA;
            $data = null;
        } else {
            $status = true;
            $message = FETCH_SUCCESS;
            $data = $prayerList->items();
        }

        $data = ['lists' => $data];
        return $this->reply($status, $message, $data, $request, __FUNCTION__);
    }

    /**
     *
     * to get specific prayer details
     *
     * @param Int id
     *
     */
    public function getPrayerHistory(Request $request)
    {
        $status = false;
        $message = TRY_AGAIN_MSG;
        $data = null;

        // get user_id from token
        $user_id = $this->extractJWT($request);

        if (!isset($request->id)) {
            $message = 'Prayer ID is required!';
        } else {
            // retrieve prayer history based on prayer id and user id
            $prayer = $this->prayer->getPrayer($request->id, $user_id);
            if ($prayer) {
                $status = true;
                $message = FETCH_SUCCESS;
                $data = $prayer;
            } else {
                $status = false;
                $message = 'Prayer data not found!';
                $data = null;
            }
        }

        return $this->reply($status, $message, $data, $request, __FUNCTION__);
    }
}
