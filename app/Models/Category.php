<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	  protected $fillable = [
        'category_name', 'parent_id', 'description', 'url', 'image', 'status','activate_categories',
    ];
    protected $table = 'categories';

    public function products(){

        return $this->hasMany('App\Models\Product', 'category_id');
    }
}
