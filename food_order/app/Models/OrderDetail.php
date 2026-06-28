<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = 'orderdetail';
    protected $primaryKey = 'orderdetail_id';
    public $timestamps = false;
    protected $fillable = ['order_id', 'menu_id', 'quantity', 'subtotal'];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'menu_id');
    }
}