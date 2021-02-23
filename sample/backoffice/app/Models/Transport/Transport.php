<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transport extends Model
{
	use SoftDeletes;
	protected $table = 'transport';
    protected $fillable = ['name','image','is_active','qty','total_stock'];

    /**
    * Belongs To Transport Type
    */
    public function type(){
    	return $this->belongsTo(TransportType::class,"type_id");
    }

        /**
    * Belongs To Transport Category
    */
    public function category(){
    	return $this->belongsTo(TransportCategory::class,"category_id");
    }
}
