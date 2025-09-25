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

        // Tambahkan satu pengguna dummy untuk Customer
        User::create([
            'user_id' => 1,
            'username' => 'guest',
            'password' => Hash::make('password'),
            'role_id' => 3, // Asumsi role_id 3 adalah untuk 'Customer'
        ]);
    }
}