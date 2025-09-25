<?php
namespace Database\Seeders;
use App\Models\Customer;
use App\Models\Order; // Tambahkan baris ini
use App\Models\OrderDetail; // Tambahkan baris ini
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Tambahkan baris ini

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan pengecekan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Hapus data dari tabel "anak" terlebih dahulu
        OrderDetail::truncate();
        Order::truncate();
        Customer::truncate();

        // Aktifkan kembali pengecekan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Tambahkan satu data pelanggan dummy
        Customer::create([
            'customer_id' => 1,
            'user_id' => 1,
            'name' => 'Guest Customer',
            'address' => 'Guest Address',
            'phone_number' => '1234567890',
        ]);
    }
}