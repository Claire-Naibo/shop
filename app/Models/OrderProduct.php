<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = 'order_product';

    protected $fillable = ['order_id', 'product_id', 'quantity', 'price', 'accompaniment_id'];

    public function orderItems()
    {
        return $this->belongsToMany(Product::class)->withPivot('product_name');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }

    public function product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    public function orders()
    {
        return $this->belongsTo('App\Models\User');
    }

}
