<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Cashier extends Model
{
    use HasFactory;
    protected $table = 'cashiers';
    protected $primaryKey = 'cashier_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['user_id', 'name', 'phone_number'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Relasi ke Payment (optional, jika ingin akses $cashier->payments)
    public function payments()
    {
        return $this->hasMany(Payment::class, 'cashier_id', 'cashier_id');
    }

    // Getter agar $cashier->full_name fallback ke name jika kosong
    public function getFullNameAttribute($value)
    {
        return $value ?: $this->name;
    }
}