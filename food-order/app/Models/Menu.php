<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';
    protected $primaryKey = 'menu_id';

    // Pastikan tabel 'menu' Anda memiliki kolom 'image' dengan tipe varchar
    protected $fillable = [
        'name',
        'description',
        'category',
        'price',
        'stock',
        'image'
    ];

    public $timestamps = false;
}