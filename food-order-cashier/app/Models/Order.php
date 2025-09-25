<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'total_price',
        'order_date',
        'order_date_only',
        'queue_number',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // === EVENT BOOT ===
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($order) {
            // Hitung total dari order details
            $order->total_price = $order->orderDetails->sum(function ($detail) {
                return $detail->quantity * $detail->menu->price;
            });
        });
    }
}
