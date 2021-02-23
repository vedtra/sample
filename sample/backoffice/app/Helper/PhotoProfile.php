<?php

namespace App\Helper;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Illuminate\Support\Facades\File;
use App\Helper\FileUpload;


class PhotoProfile
{
	public static function upload($request,$image_name,$folder){        
        /*Assign value Url after saveing*/
        $img_url=null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            
            $filename=$file->getClientOriginalName();
            $imgmanage=new FileUpload(); 
            $originName=$image_name;
            $filename=$originName.".".$file->getClientOriginalExtension();
            /*Check if Folder is Exsist*/
            $profile_folder = './upload/profile/'.$folder;
            if(!File::exists($profile_folder)) {
                // path does not exist
                File::makeDirectory(public_path().'/'.$profile_folder,0777,true);
            }
            
            $flag=$imgmanage->isExist($profile_folder,$filename);
            if($flag)
            {
                $imgmanage->deleteImage($profile_folder,$filename);
            }
            $img_loc=url('').$imgmanage->save($profile_folder,$file,$filename);           
            /*Create ori resize*/
            $originName .= "_avatar";
            $ori_loc=$imgmanage->create_ori_resize($profile_folder, $filename, "png",$originName);
            $img_url=$ori_loc;
            $imgmanage->deleteImage($profile_folder,$filename);            
        }
        return $img_url;
    }

}
