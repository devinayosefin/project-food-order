<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    public $timestamps = false;
    protected $fillable = ['customer_id', 'total_price', 'order_date'];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'order_id');
    }

    // Agar bisa akses $order->details di view
    public function details()
    {
        return $this->orderDetails();
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function cashier()
    {
        return $this->belongsTo(Cashier::class, 'cashier_id', 'cashier_id');
    }
}