<?php

namespace App\Models\Coupon;
use App\Models\Master\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
	use SoftDeletes;
	protected $table = 'coupon';
    protected $fillable = ['title','type','min_payment','company_id'];
   
   public function company(){
    	return $this->belongsTo(Company::class,"company_id");
    }
}
