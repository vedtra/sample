<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Auth;
use DataTables;
use Cloudder;
use App\Models\Blog\Blog;



class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data["bread_crumb"] = "Blog & Page";
        $data["title"] = "Manage Blog";
        return view('blog.index',$data);
    }

    public function get(Request $req){
        $blog = Blog::orderBy("title","asc")->get();

        foreach ($blog as $item ) {
            $item->thumbnail="<img src='$item->thumbnail' width='70' />"; 
            if($item->status == Blog::DRAFT){
                $item->status = "<label class='label label-info'>".$item->getStatus()."</label>";
            }else if($item->status == Blog::PUBLISHED){
                 $item->status = "<label class='label label-success'>".$item->getStatus()."</label>";
            }else{
                 $item->status = "<label class='label label-danger'>".$item->getStatus()."</label>";
            }
        }
        return Datatables::of($blog)->rawColumns(["status"])->make(true);
    }
    
    public function create(Request $req){
        
        $data["title"] = "New Blog";
        return view("blog.form",$data);
    }
    public function edit($id){
        $data["data"] = BLog::findOrFail($id);
        $data["title"] = "Edit Blog";
        return view("blog.form",$data);
    }

    public function detail($slug){
        $data["data"] = Blog::where("slug",$slug)->first();
        $data["title"] = @$data["data"]->title;
        return view("blog.detail",$data);
    }
    public function store(Request $req){
        $data = $req->all();
        
        $rules = [
            'title' => 'required|string',
            'seo_title'=>'required|string',
            'content'=>'required',
        ];
        /**
        * If Create New Data, Field Thumbnail as Required Uploaded 
        * Else Not
        */
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
                $res_data = Blog::findOrFail($req->input("id"));
            }else{
                $res_data = new Blog();
            }
            $res_data->title = $req->input("title");
            $res_data->seo_title = $req->input("seo_title");
            /*Using STR Function to generate slug text*/
            $res_data->slug = Str::slug($req->input("title"),'-');
            $res_data->created_by = auth()->user()->name;
            $res_data->status = $req->input("status");
            $res_data->content = $req->input("content");

            /*Upload File Image*/
            if($thumbnail_file = $req->file("thumbnail")){
                $public_id_thumbnail = "snaptig_page_".time();
                Cloudder::upload($thumbnail_file, $public_id_thumbnail, array("width"=>600, "gravity"=>"faces", "crop"=>"fill"),null);
                $url_image = Cloudder::secureShow($public_id_thumbnail, ["width" => 600]);
                $res_data->thumbnail = $url_image;
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
        $dt = BLog::findOrFail($id);
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
