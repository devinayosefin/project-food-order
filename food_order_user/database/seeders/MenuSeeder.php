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
        Menu::create(['name' => "Kopi'O Regal", 'description' => "Nikmati kelezatan Kopi'O dengan kesegaran minuman Kopi'O series", 'category' => 'coffee', 'price' => 24000.00, 'stock' => 100, 'image' => 'kopi-regal.png']);
        Menu::create(['name' => "Kopi'O Hazelnut", 'description' => "Nikmati kelezatan Kopi'O dengan kesegaran minuman Kopi'O series", 'category' => 'coffee', 'price' => 24000.00, 'stock' => 100, 'image' => 'kopi-hazelnut.png']);
        Menu::create(['name' => "Butterscotch Latte", 'description' => "Nikmati kelezatan Kopi'O dengan kesegaran minuman Kopi'O series", 'category' => 'coffee', 'price' => 26000.00, 'stock' => 100, 'image' => 'butterscotch-latte.png']);
        Menu::create(['name' => "Signature Coffee Bun", 'description' => "Roti'O menyedikan Roti'O dengan topping coffee bun yang lezat. Roti'O selalu disajikan dalam keadaan hangat.", 'category' => 'roti', 'price' => 15000.00, 'stock' => 100, 'image' => 'bun.png']);
        Menu::create(['name' => "Pastry Beef", 'description' => "Nikmati varian menu Pastry-nya Roti'O yang manis dan gurih", 'category' => 'pastry', 'price' => 14000.00, 'stock' => 100, 'image' => 'pastry-beef.png']);
        Menu::create(['name' => "Pastry Chicken", 'description' => "Nikmati varian menu Pastry-nya Roti'O yang manis dan gurih", 'category' => 'pastry', 'price' => 12000.00, 'stock' => 100, 'image' => 'pastry-chicken.png']);
    }
}