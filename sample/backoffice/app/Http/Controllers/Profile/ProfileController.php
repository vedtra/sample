<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DataTables;
use Spatie\Permission\Models\Role;
use App\User;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    
    /*View Form Change Password*/
    public function formPassword()
    {
        $data["bread_crumb"] = "Account";
        $data["title"] = "Change Password";
        return view('profile.changepassword',$data);
    }

    public function updatePassword(Request $req){
    	$data = $req->all();
        $rules = [
            'password' => 'required|confirmed',
            'old_password' => 'required'
        ];
        /*Do Validation*/
        $validator = Validator::make($data,$rules);
        if ($validator->fails()) {
            $resultfeed = new \StdClass();
            $resultfeed->status = "error";
            $message = "<ul>";
            foreach($validator->errors()->all() as $item){
                $message .="<li>".$item."</li>";
            }
            $message .="</ul>";
            $resultfeed->message = $message;
            $resultfeed->data = "";
            return json_encode($resultfeed);                 
        }else{
        	$dt_user = auth()->user();
        	/*Check if Old Password in Correct*/
        	if(Hash::check($req->input("old_password"), $dt_user->password)){
	        	$dt_user->password = bcrypt($req->input("password"));
	        	if($dt_user->save()){
		            $resultfeed = new \StdClass();
		            $resultfeed->status = "success";
		            $resultfeed->message = "Password is updated";
		            $resultfeed->data = "";
		            return json_encode($resultfeed);
		        }else{
		            $resultfeed = new \StdClass();
		            $resultfeed->status = "error";
		            $resultfeed->message = "Opps, Something wrong";
		            $resultfeed->data = "";
		            return json_encode($resultfeed);
		        }
	        }else{
	        	$resultfeed = new \StdClass();
	            $resultfeed->status = "error";
	            $resultfeed->message = "Your Old Password is Wrong";
	            $resultfeed->data = "";
	            return json_encode($resultfeed);
	        }
        }
    }
}
