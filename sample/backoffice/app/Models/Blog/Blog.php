<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use SoftDeletes;
	
    protected $table = 'blog';
    protected $fillable = ['title','content','thumbnail','created_by'];

    const DRAFT = 0;
    const PUBLISHED = 1;
    const UNPUBLISHED = 2;

    const STATUS = [
    	self::DRAFT => "Draft",
    	self::PUBLISHED => "Published",
    	self::UNPUBLISHED => "Unpublished"
    ];

    public function getStatus(){
    	return self::STATUS[$this->status];
    }
}
