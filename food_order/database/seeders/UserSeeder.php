<?php
namespace Database\Seeders;
use App\Models\User;
use App\Models\Cashier; // Tambahkan baris ini
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Matikan sementara pengecekan foreign key untuk menghindari error
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Hapus data dari tabel yang berelasi
        Cashier::truncate();
        User::truncate();
        
        // Aktifkan kembali pengecekan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Tambahkan pengguna dummy untuk Admin
        User::create([
            'user_id' => 1,
            'username' => 'admin',
            'email' => 'admin@roti-o.com',
            'password' => Hash::make('admin123'),
            'role_id' => 1, // 1 = admin
        ]);

        User::create([
            'user_id' => 2,
            'username' => 'kasir',
            'email' => 'kasir@roti-o.com',
            'password' => Hash::make('kasir123'),
            'role_id' => 2, // 2 = cashier
        ]);
    }
}