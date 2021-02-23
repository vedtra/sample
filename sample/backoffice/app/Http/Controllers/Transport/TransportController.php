<?php

namespace App\Http\Controllers\Transport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DataTables;
use Cloudder;
use App\Models\Transport\Transport;
use App\Models\Transport\TransportType;
use App\Models\Transport\TransportCategory;



class TransportController extends Controller
{
    
    public function index()
    {
        $data["bread_crumb"] = "Transport";
        $data["title"] = "Manage Transport";
        return view('transport.index',$data);
    }

    public function get(Request $req){
        $transport = Transport::orderBy("name","asc")->get();
        foreach ($transport as $item ) {
            $item->image="<img src='$item->image' width='70' />"; 
            $item->type;
            $item->category;
            if($item->is_active){
                $item->status = "<label class='label label-success'>Active</label>";
            }else{
                $item->status = "<label class='label label-danger'>Non-Active</label>";
            }
        }            
        return Datatables::of($transport)->rawColumns(["status","image"])->make(true);
    }
    
    public function create(Request $req){
       
        $data["title"] = "New Transport";
        $data["types"] = TransportType::all();
        $data["categories"] = TransportCategory::all();
        return view("transport.form",$data);
    }
    public function edit($id){
        $data["data"] = Transport::findOrFail($id);
        $data["title"] = "Edit Transport";
        $data["types"] = TransportType::all();
        $data["categories"] = TransportCategory::all();
        return view("transport.form",$data);
    }

    public function store(Request $req){
        $data = $req->all();
        $rules = [
            'name' => 'required|string',
            'status'=> 'required',
            'type'=> 'required',
            'category'=> 'required',
            'qty'=> 'required|numeric',
            'total_stock'=> 'required|numeric',
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
                $res_data = Transport::findOrFail($req->input("id"));
            }else{
                $res_data = new Transport();
            }
            $res_data->name = $req->input("name");
            $res_data->is_active = $req->input("status");
            $res_data->qty = $req->input("qty");
            $res_data->total_stock = $req->input("total_stock");
            $res_data->type_id = $req->input("type");
            $res_data->category_id = $req->input("category");
            
            /*Check if Uploaded File is exsist in Request*/
            if($thumbnail_file = $req->file("image")){
                $public_id_thumbnail = "transport_".time();
                Cloudder::upload($thumbnail_file, $public_id_thumbnail, array("width"=>600, "gravity"=>"faces", "crop"=>"fill"),null);
                $url_image = Cloudder::secureShow($public_id_thumbnail, ["width" => 600]);
                $res_data->image = $url_image;
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
        $dt = Transport::findOrFail($id);
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
