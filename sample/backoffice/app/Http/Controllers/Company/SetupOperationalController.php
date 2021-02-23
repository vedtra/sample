<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Auth;
use DataTables;
use App\Models\Master\CompanyOperational;
use App\User;

class SetupOperationalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(){
        $data["title"] = "Operational";
        $data["data"] =CompanyOperational::all();
        return view("company.operational.form",$data);
    }

    public function store(Request $req){
        $data = $req->all();
        // dd($data);
        $rules = [
            'senin' => 'required',
            'selasa' => 'required',
            'rabu' => 'required',
            'kamis' => 'required',
            'jumat' => 'required',
            'sabtu' => 'required',
            'minggu' => 'required',           
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
            $res_data = new CompanyOperational();
            $res_data->sunday = $req->input("senin");
            $res_data->monday = $req->input("selasa");
            $res_data->tuesday = $req->input("rabu");
            $res_data->wednesday = $req->input("kamis");
            $res_data->friday = $req->input("jumat");
            $res_data->saturday = $req->input("sabtu");
            $res_data->start_at = $req->input("start_at");
            $res_data->endt_at = $req->input("endt_at");          
            $res_data->save();
            /*Return Result*/
            $resultfeed = new \StdClass();
            $resultfeed->status = "success";            
            $resultfeed->message = "Data is sucessfull stored";            
            $resultfeed->data = ""; 
            return json_encode($resultfeed);
        }
        
    }

}    

