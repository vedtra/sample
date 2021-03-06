<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DataTables;
use Spatie\Permission\Models\Role;
use App\User;


class AccountController extends Controller
{
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data["bread_crumb"] = "User Account";
        $data["title"] = "Manage User";
        return view('user.index',$data);
    }
    public function get(Request $req){
        $rs = User::orderBy("name","asc")->get();
        foreach($rs as $user){
            $user->role = "";
            if(!empty($user->getRoleNames())){
                foreach ($user->getRoleNames() as $value) {
                    # code...
                    $user->role .= "<label class='label label-info'>".$value."</label> ";
                }
            }
            if($user->email_verified_at){
                $user->status = "<label class='label label-success'>Yes</label> "; 
            }else{
                $user->status = "<label class='label label-danger'>No</label> "; 
            }
        }             
        return Datatables::of($rs)->rawColumns(["role","status"])->make(true);

    }
    public function create(Request $req){
        $data["title"] = "New User";
        $data["roles"] = Role::orderBy("name","asc")->get();
        return view("user.form",$data);
    }
    public function edit($id){
        $user_selected = User::findOrFail($id);
        $data["data"] = $user_selected;
        $data["title"] = "Edit User";
        $data["roles"] = Role::orderBy("name","asc")->get();
        $data['selected_role'] = @$user_selected->getRoleNames()[0];
        return view("user.form",$data);
    }
    public function store(Request $req){
        $data = $req->all();
        $rules = [
            'name' => 'required|string',
            'email' => 'required|string'
        ];
        if(!$req->input("id")){
            $rules['password'] = 'required|confirmed';
        }
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
            if($req->input("id")){
                $res_data = User::findOrFail($req->input("id"));
            }else{
                $res_data = new User();
                $res_data->password = bcrypt($req->input("password"));
            }
            $res_data->name = $req->input("name");
            $res_data->email = $req->input("email");
            $res_data->save();
            /*If Role is Selected*/
            if($req->input("role")){
                $dt_role = Role::findOrFail($req->input("role"));
                $res_data->syncRoles($dt_role);
            }
            /*Return Result*/
            $resultfeed = new \StdClass();
            $resultfeed->status = "success";            
            $resultfeed->message = "Data is sucessfull stored";            
            $resultfeed->data = "";
            return json_encode($resultfeed);
        }
    }
    public function destroy($id){
        $dt = User::findOrFail($id);
        if($dt->delete()){
            $resultfeed = new \StdClass();
            $resultfeed->status = "success";
            $resultfeed->message = "Data is deleted";
            $resultfeed->data = "";
            return json_encode($resultfeed);
        }else{
            $resultfeed = new \StdClass();
            $resultfeed->status = "error";
            $resultfeed->message = "Opps, Something wrong";
            $resultfeed->data = "";
            return json_encode($resultfeed);
        }
    }
}
