<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'product_name', 'product_code', 'description','price',
    ];

    public function attributes() {
        return $this->hasMany('App\Products_Attributes', 'product_id');
    }   

    public function category() {
        return $this->belongsTo('App\Category');
    }

    public function orderProduct() {
        return $this->belongsTo('App\OrderProduct', 'product_id', 'id');
    }
}
