<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'name', 'address', 'mobile', 'email', 'total', 'dispatch_status', 'status'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany('App\Models\OrderProduct','order_id');
    }

    public function orderItems()
    {
        return $this->hasMany('App\Models\OrderProduct');
    }
    //this is used in the admin end on orders
    public function Items(){
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product');
    }

    public function orderUsers()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function deliveryDetails()
    {
        return $this->hasMany('App\Models\DeliveryDetails', 'order_id', 'id');
    }

}
