<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    // Nama tabel 'orders' sudah sesuai konvensi, jadi tidak perlu $table
    
    protected $primaryKey = 'order_id';
    
    // Tabel Anda memiliki kolom 'order_date', bukan created_at/updated_at
    // Kita perlu mendefinisikannya agar Eloquent tahu
    const CREATED_AT = 'order_date';
    const UPDATED_AT = null; // Tidak ada kolom updated_at

    protected $fillable = [
        'customer_id',
        'total_price',
    ];
}