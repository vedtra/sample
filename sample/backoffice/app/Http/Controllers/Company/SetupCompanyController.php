<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Auth;
use DataTables;
use App\Models\Master\Company;
use App\Models\Master\CompanyDetail;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use App\User;
class SetupCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(){
        $usercompany =Auth::User()->company_id;
        // dd($usercompany);
        $data["data"] = CompanyDetail::where('company_id',$usercompany)->first();
        $data["title"] = "Setup";
        $data["companies"] = Company::all();
        $data["provincies"] = Province::all();
        $data["cities"] = City::all();
        return view("company.detail.form",$data);
    }

    public function store(Request $req){
        $data = $req->all();
        // dd($data);
        $rules = [
            'company_id' => 'required|string',           
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
            $usercompany =Auth::User()->company_id;
            // 
            $checkdata = CompanyDetail::where('company_id',$usercompany)->first();
            if($checkdata){
            // dd($checkdata);
                $res_data = CompanyDetail::where('company_id',$usercompany)->first();
                
            }
           if(!$checkdata){
                    $res_data = new CompanyDetail();      
            }         
            $res_data->company_id = $req->input("company_id");
            $res_data->province_id = $req->input("province_id");
            $res_data->city_id = $req->input("city_id");
            $res_data->address = $req->input("address");
            $res_data->website = $req->input("website");
            $res_data->contact_01 = $req->input("contact_01");
            $res_data->contact_02 = $req->input("contact_02");
            $res_data->bank_name = $req->input("bank_name");
            $res_data->bank_account = $req->input("bank_account");          
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
