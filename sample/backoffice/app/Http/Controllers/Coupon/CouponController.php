<?php

namespace App\Http\Controllers\Coupon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Auth;
use DataTables;
use Cloudder;
use App\Models\Coupon\Coupon;
use App\Models\Master\Company;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $data["bread_crumb"] = "Coupon";
        $data["title"] = "Manage Coupon";
        return view('coupon.index',$data);
    }

    public function get(Request $req){
        $coupon = Coupon::orderBy("title","asc")->get();


        foreach ($coupon as $item ) {
            $item->thumbnail="<img src='$item->thumbnail' width='50' />";
            $item->company;
        }

        return Datatables::of($coupon)->rawColumns(["status","thumbnail"])->make(true);
    }

    public function create(Request $req){
        $data["title"] = "New Coupon";
        $data["companies"] = Company::all();
        return view("coupon.form",$data);
    }
    public function edit($id){
        $data["data"] = Coupon::findOrFail($id);
        $data["title"] = "Edit Coupon";
        $data["companies"] = Company::all();
        return view("coupon.form",$data);
    }

    public function store(Request $req){
        $data = $req->all();
        $rules = [
            'title' => 'required|string',
            'type'=> 'required',
            'min_payment'=>'required',
            'company' =>'required',
            'date_range'=>'required',
            'content'=>'required',


        ];
        if(!$req->input("id")){
             $rules["thumbnail"] = 'required|mimes:jpeg,bmp,jpg,png|between:1, 8000';
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
                $res_data = Coupon::findOrFail($req->input("id"));
            }else{
                $res_data = new Coupon();
            }

            $res_data->title = $req->input("title");
            $res_data->type = $req->input("type");
            $res_data->code = $req->input("code");
            $res_data->min_payment = $req->input("min_payment");
            $date_range = explode("-",$req->input("date_range"));//04/11/2019 - 04/27/2019
            $res_data->start_date = date("Y-m-d",strtotime(@$date_range[0]));//First Element after Explore
            $res_data->end_date = date("Y-m-d",strtotime(@$date_range[1]));
            $res_data->company_id = $req->input("company");
            $res_data->content = $req->input("content");

            $thumbnail  = $req->file('thumbnail');


            /*Create Public Id as Identified in Cloudinary*/
            if($thumbnail){
                $public_id_thumbnail = "snaptig_thumbnail".time();
                Cloudder::upload($thumbnail, $public_id_thumbnail, array("width"=>600, "gravity"=>"faces", "crop"=>"fill"),null);
                $url_thumbnail = Cloudder::secureShow($public_id_thumbnail, ["width" => 600]);
                $res_data->thumbnail = $url_thumbnail;
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
        $dt = Coupon::findOrFail($id);
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

