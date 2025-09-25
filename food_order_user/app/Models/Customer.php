<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    protected $primaryKey = 'customer_id';
    public $timestamps = false;
    protected $fillable = ['user_id', 'name', 'address', 'phone_number'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}