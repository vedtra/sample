<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DataTables;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionManagerController extends Controller
{
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     * Return All Role And Permission Registered
     */
    public function index()
    {
        $data["bread_crumb"] = "Permission";
        $data["title"] = "Permission Manager";
        /*Get All Permission Menu*/
        $data["permission"] = Permission::orderBy("created_at","asc")->get();
        /*Get All Role Menu*/
        $data["roles"] = Role::orderBy("name","asc")->get();
        return view('permission.manager',$data);
    }
    
    public function store(Request $req){
        $data = $req->all();
        $rules = [
            'role' => 'required',
            'permission' => 'required'
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
            $data_role = Role::findOrFail($req->input("role"));
            $data_permission = Permission::findOrFail($req->input("permission"));
            if($data_role->hasPermissionTo($data_permission)){
                $data_role->revokePermissionTo($data_permission);
            }else{
                $data_role->givePermissionTo($data_permission);                
            }

            /*Return Result*/
            $resultfeed = new \StdClass();
            $resultfeed->status = "success";            
            $resultfeed->message = "Data is sucessfull updated";            
            $resultfeed->data = "";
            return json_encode($resultfeed);
        }
    }
}
