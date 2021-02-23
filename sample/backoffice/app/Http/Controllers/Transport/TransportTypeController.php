<?php

namespace App\Http\Controllers\Transport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DataTables;
use App\Models\Transport\TransportType;


class TransportTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data["bread_crumb"] = "Transport Type";
        $data["title"] = "Manage Transport Type";
        return view('transport.type.index',$data);
    }

    public function get(Request $req){
        $transporttype = TransportType::orderBy("name","asc")->get();            
        return Datatables::of($transporttype)->rawColumns(["status"])->make(true);
    }
    
    public function create(Request $req){
        $data["title"] = "New Transport Type";
        return view("transport.type.form",$data);
    }
    public function edit($id){
        $data["data"] = TransportType::findOrFail($id);
        $data["title"] = "Edit  Transport Type";
        return view("transport.type.form",$data);
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
                $res_data = TransportType::findOrFail($req->input("id"));
            }else{
                $res_data = new TransportType();
            }
            $res_data->name = $req->input("name");
            $res_data->description = $req->input("description");
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
        $dt = TransportType::findOrFail($id);
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
