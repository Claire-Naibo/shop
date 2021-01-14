<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'product_name', 'product_code', 'description','price',
    ];

    public function category() {
        return $this->belongsTo('App\Category');
    }

    public function orderProduct() {
        return $this->belongsTo('App\OrderProduct', 'product_id', 'id');
    }
}
