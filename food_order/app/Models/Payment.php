<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'payment_id';
    protected $fillable = [
        'order_id',
        'cashier_id',
        'payment_date',
        'payment_amount',
        'payment_status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function cashier()
    {
        return $this->belongsTo(Cashier::class, 'cashier_id', 'cashier_id');
    }
}
