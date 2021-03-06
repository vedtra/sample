<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DataTables;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data["bread_crumb"] = "Permission";
        $data["title"] = "Manage Permission";
        return view('permission.index',$data);
    }
    public function get(Request $req){
        $rs = Permission::orderBy("name","asc")->get();             
        return Datatables::of($rs)->rawColumns(["status"])->make(true);

    }
    public function create(Request $req){
        $data["title"] = "New Permission";
        return view("permission.form",$data);
    }
    public function edit($id){
        $data["data"] = Permission::findOrFail($id);
        $data["title"] = "Edit Permission";
        return view("permission.form",$data);
    }
    public function store(Request $req){
        $data = $req->all();
        $rules = [
            'name' => 'required|string',
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
            if($req->input("id")){
                $res_data = Permission::findOrFail($req->input("id"));
            }else{
                $res_data = new Permission();
            }
            $res_data->name = $req->input("name");
            $res_data->save();
            /*Return Result*/
            $resultfeed = new \StdClass();
            $resultfeed->status = "success";            
            $resultfeed->message = "Data is sucessfull stored";            
            $resultfeed->data = "";
            return json_encode($resultfeed);
        }
    }
    public function destroy($id){
        $dt = Permission::findOrFail($id);
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
