<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Model;

class TransportCategory extends Model
{
	protected $table = 'transport_category';
    protected $fillable = ['name'];


    public function transport(){
    	return $this->hasMany(Transport::class,"category_id");
    }
}
