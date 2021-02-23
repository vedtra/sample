<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;

class CompanyDetail extends Model
{
	protected $table = 'company_details';

    /*Relation*/
    /*Belongs to Company */
    public function company(){
    	return $this->belongsTo(Company::class,"company_id");
    }
    /*Relation*/
    /*Belongs to Province */
    public function province(){
    	return $this->belongsTo(Province::class,"province_id");
    }
    /*Relation*/
    /*Belongs to City */
    public function city(){
    	return $this->belongsTo(City::class,"city_id");
    }
}
