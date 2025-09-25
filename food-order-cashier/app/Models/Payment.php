<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';
    protected $fillable = ['order_id', 'cashier_id', 'payment_date', 'payment_amount', 'payment_status'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // amount = total order
    public function getPaymentAmountAttribute()
    {
        return $this->order ? $this->order->total_price : 0;
    }
}
