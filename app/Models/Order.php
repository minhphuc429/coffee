<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'status', 'customer_name', 'customer_address', 'customer_phone', 'delivery_time', 'shipping_fee', 'payment_method', 'total'];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function products() {
        return $this->belongsToMany('App\Models\Product');
    }
}
