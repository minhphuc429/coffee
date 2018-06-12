<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $softDelete = true;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    protected $fillable = ['user_id', 'status', 'customer_name', 'customer_address', 'customer_phone', 'delivery_time', 'shipping_fee', 'payment_method', 'total'];

    public static function getPossibleStatuses()
    {
        $type = DB::select(DB::raw('SHOW COLUMNS FROM orders WHERE Field = "status"'))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $values = [];
        foreach (explode(',', $matches[1]) as $value) {
            $values[trim($value, "'")] = ucfirst(trim($value, "'"));
        }
        return $values;
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product')
            ->withPivot('product_option', 'quantity');
    }
}
