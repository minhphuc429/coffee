<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    public $timestamps = false;
    protected $fillable = ['key', 'value', 'surcharge'];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
