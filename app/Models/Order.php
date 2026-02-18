<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'order_number',
        'user_id',
        'branch_store_id',
        'address_id',
        'subtotal',
        'shipping_cost',
        'discount',
        'grand_total',
        'status',
        'payment_status',
        'payment_method',
        'snap_token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
