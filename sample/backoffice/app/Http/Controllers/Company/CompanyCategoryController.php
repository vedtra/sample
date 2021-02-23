<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DataTables;
use Cloudder;
use App\Models\Master\CompanyCategory;

class CompanyCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data["bread_crumb"] = "Company Category";
        $data["title"] = "Manage Company Category";
        return view('company.category.index',$data); 
    }

    public function get(Request $req){
        $company = CompanyCategory::orderBy("name","asc")->get();             
        return Datatables::of($company)->rawColumns(["status"])->make(true);
    }
    
    public function create(Request $req){
        $data["title"] = "New Company Category";
        return view("company.category.form",$data);
    }
    public function edit($id){
        $data["data"] = CompanyCategory::findOrFail($id);
        $data["title"] = "Edit Category Company";
        return view("company.category.form",$data);
    }

    public function store(Request $req){
        $data = $req->all();
        $rules = [
            'name' => 'required|string',
            'code' => 'required|string'
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
                $res_data = CompanyCategory::findOrFail($req->input("id"));
            }else{
                $res_data = new CompanyCategory();
            }
            $res_data->name = $req->input("name");
            $res_data->code = $req->input("code");
            $res_data->notes = $req->input("notes");
            /*Save File image Icon is found*/
            if($req->file("icon")){
                $icon_file = $req->file("icon");
                $public_id_icon = "snaptig_icon_".time();
                Cloudder::upload($icon_file, $public_id_icon, array("width"=>600, "gravity"=>"faces", "crop"=>"fill"),null);
                $link_icon = Cloudder::secureShow($public_id_icon, ["width" => 600]);
                $res_data->icon = $link_icon;
            }
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
        $dt = CompanyCategory::findOrFail($id);
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
