<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Model;

class TransportType extends Model
{
	protected $table = 'transport_type';
    protected $fillable = ['name'];

     public function transport(){
    	return $this->hasMany(Transport::class,"type_id");
    }
}
