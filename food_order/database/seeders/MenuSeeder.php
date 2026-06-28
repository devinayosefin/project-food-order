<?php
namespace Database\Seeders;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Tambahkan baris ini

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Matikan sementara pengecekan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Hapus data dari semua tabel yang berelasi
        OrderDetail::truncate(); 
        Order::truncate();
            Menu::truncate();

        // Aktifkan kembali pengecekan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Isi ulang data ke tabel menu
            Menu::insert([
            ]);
    }
}