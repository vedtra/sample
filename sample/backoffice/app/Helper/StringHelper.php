<?php

namespace App\Helper;

class StringHelper
{
	public static function randomString($length){
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < $length; $i++) 
            { $randstring .= $characters[rand(0, (strlen($characters)-1) )];}
        return $randstring;
	}

	public static function rupiahFormat($amount){
		return "Rp. ".number_format($amount,2);
	}

	public static function dateFormat($str_date){
		return date('d M Y H:i:s',strtotime($str_date));
	}
}
