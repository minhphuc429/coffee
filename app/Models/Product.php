<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id', 'name', 'image', 'price'];

    public function category() {
        return $this->belongsTo('App\Models\Category');
    }

    public function productOptions() {
        return $this->hasMany('App\Models\ProductOption');
    }

    public function orders() {
        return $this->belongsToMany('App\Models\Order')
            ->withPivot('product_option');
    }
}
