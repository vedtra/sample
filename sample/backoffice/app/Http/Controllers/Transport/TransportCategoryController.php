<?php

namespace App\Http\Controllers\Transport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DataTables;
use App\Models\Transport\TransportCategory;

class TransportCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data["bread_crumb"] = "Transport Category";
        $data["title"] = "Manage Transport Category";
        return view('transport.category.index',$data);
    }

    public function get(Request $req){
        $transportcategory = TransportCategory::orderBy("name","asc")->get();            
        return Datatables::of($transportcategory)->rawColumns(["status"])->make(true);
    }
    
    public function create(Request $req){
        $data["title"] = "New Transport Category";
        return view("transport.category.form",$data);
    }
    public function edit($id){
        $data["data"] = TransportCategory::findOrFail($id);
        $data["title"] = "Edit Category Transport";
        return view("transport.category.form",$data);
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
                $res_data = TransportCategory::findOrFail($req->input("id"));
            }else{
                $res_data = new TransportCategory();
            }
            $res_data->name = $req->input("name");
            $res_data->desc = $req->input("desc");
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
        $dt = TransportCategory::findOrFail($id);
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
