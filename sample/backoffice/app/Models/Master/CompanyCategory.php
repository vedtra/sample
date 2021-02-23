<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class CompanyCategory extends Model
{
	protected $table = 'company_category';
    protected $fillable = ['name','code','desc'];

    /**
    * Relation has Many Company
    * 
    */
    public function companies(){
    	return $this->hasMany(Company::class,"category_id");
    }
}
