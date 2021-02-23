<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
	use SoftDeletes;
	protected $table = 'company';
    protected $fillable = ['name','banner','logo','category_id'];

    /*Relation*/
    /*Belongs to Company Category*/
    public function category(){
    	return $this->belongsTo(CompanyCategory::class,"category_id");
    }
}
