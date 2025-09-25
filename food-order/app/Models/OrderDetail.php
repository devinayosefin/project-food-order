<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    /**
     * Baris ini adalah solusinya.
     * Kita memberitahu Laravel bahwa model ini terhubung ke tabel bernama 'orderdetail'.
     */
    protected $table = 'orderdetail';

    // Tentukan juga primary key jika bukan 'id'
    protected $primaryKey = 'orderdetail_id';

    // Matikan timestamps karena tabel Anda tidak memilikinya
    public $timestamps = false;

    // Izinkan mass assignment untuk kolom ini
    protected $fillable = [
        'order_id',
        'menu_id',
        'quantity',
        'subtotal'
    ];
}