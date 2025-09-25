<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Cashier extends Model
{
    use HasFactory;
    protected $table = 'cashiers';
    protected $primaryKey = 'cashier_id';
    public $timestamps = false;
    protected $fillable = ['user_id', 'full_name', 'phone_number'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}