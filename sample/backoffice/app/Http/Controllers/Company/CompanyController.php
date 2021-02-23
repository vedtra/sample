<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Auth;
use DataTables;
use Cloudder;
use App\Models\Master\Company;
use App\Models\Master\CompanyCategory;


class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $data["bread_crumb"] = "Company";
        $data["title"] = "Manage Company";
        return view('company.index',$data);
    }

    public function get(Request $req){
        $company = Company::orderBy("name","asc")->get();

        foreach ($company as $item ) {
            $item->logo="<img src='$item->logo' width='50' />"; 
            $item->category;
        }

        return Datatables::of($company)->rawColumns(["status","banner","logo"])->make(true);
    }
    
    public function create(Request $req){
        $data["title"] = "New Company";
        $data["categories"] = CompanyCategory::all();
        return view("company.form",$data);
    }
    public function edit($id){
        $data["data"] = Company::findOrFail($id);
        $data["title"] = "Edit Company";
        $data["categories"] = CompanyCategory::all();
        return view("company.form",$data);
    }

    public function store(Request $req){
        $data = $req->all();
        // dd($data);
        $rules = [
            'name' => 'required|string',
            'category_id'=> 'required',
            
        ];
        if(!$req->input("id")){
             $rules["logo"] = 'required|mimes:jpeg,bmp,jpg,png|between:1, 8000';
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
                $res_data = Company::findOrFail($req->input("id"));
            }else{
                $res_data = new Company();
            }
            
            $res_data->name = $req->input("name");
            $res_data->category_id = $req->input("category_id");
            $res_data->description = $req->input("description");
            $banner_file  = $req->file('banner');
            $logo_file = $req->file('logo');

            /*Create Public Id as Identified in Cloudinary*/
            if($banner_file){
                $public_id_banner = "snaptig_banner".time();
                Cloudder::upload($banner_file, $public_id_banner, array("width"=>600, "gravity"=>"faces", "crop"=>"fill"),null);
                $url_banner = Cloudder::secureShow($public_id_banner, ["width" => 600]);
                $res_data->banner = $url_banner;
            }

            if($logo_file){
                $public_id_logo = "snaptig_logo".time();
                Cloudder::upload($logo_file, $public_id_logo, array("width"=>600, "gravity"=>"faces", "crop"=>"fill"),null);
                // dd($public_id_logo);
                $url_logo = Cloudder::secureShow($public_id_logo, ["width" => 600]);    
                $res_data->logo = $url_logo;
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
        $dt = Company::findOrFail($id);
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
