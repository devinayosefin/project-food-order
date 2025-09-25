<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;

class FoodOrderSeeder extends Seeder
{
    public function run(): void
    {
        // Kosongkan tabel dulu biar tidak dobel
        DB::table('orderdetail')->truncate();
        DB::table('payment')->truncate();
        DB::table('orders')->truncate();
        DB::table('customers')->truncate();
        DB::table('menu')->truncate();

        // ================= MENU =================
        $menus = [
            [
                'name' => 'Butterscotch',
                'description' => 'Minuman manis rasa butterscotch',
                'category' => 'Minuman',
                'price' => 25000,
                'stock' => 20,
                'foto' => 'images/butterscotch.png',
            ],
            [
                'name' => 'Croissant',
                'description' => 'Roti croissant lembut dan gurih',
                'category' => 'Pastry',
                'price' => 20000,
                'stock' => 15,
                'foto' => 'images/croissant.png',
            ],
            [
                'name' => 'Kopi Hazelnut',
                'description' => 'Kopi dengan aroma hazelnut',
                'category' => 'Minuman',
                'price' => 30000,
                'stock' => 25,
                'foto' => 'images/kopi hazelnut.png',
            ],
            [
                'name' => 'Kopi Regal',
                'description' => 'Kopi dengan rasa regal',
                'category' => 'Minuman',
                'price' => 28000,
                'stock' => 25,
                'foto' => 'images/kopi regal.png',
            ],
            [
                'name' => 'Pastry Beef',
                'description' => 'Pastry isi daging sapi',
                'category' => 'Pastry',
                'price' => 35000,
                'stock' => 10,
                'foto' => 'images/pastry beef.png',
            ],
            [
                'name' => 'Pastry Chicken',
                'description' => 'Pastry isi ayam gurih',
                'category' => 'Pastry',
                'price' => 32000,
                'stock' => 12,
                'foto' => 'images/pastry chicken.png',
            ],
            [
                'name' => 'Pastry Chocolate',
                'description' => 'Pastry isi cokelat manis',
                'category' => 'Pastry',
                'price' => 30000,
                'stock' => 15,
                'foto' => 'images/pastry chocolate.png',
            ],
            [
                'name' => 'Rotio',
                'description' => 'Roti isi kopi khas RotiO',
                'category' => 'Pastry',
                'price' => 18000,
                'stock' => 30,
                'foto' => 'images/rotio.png',
            ],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }

        // ================= CUSTOMERS =================
        $customers = [
            ['name' => 'Devina Yosefin', 'address' => 'Jl. Melati No.1', 'phone_number' => '0811111111'],
            ['name' => 'Melda Jessica', 'address' => 'Jl. Mawar No.2', 'phone_number' => '0822222222'],
            ['name' => 'Gizha Pradipta', 'address' => 'Jl. Anggrek No.3', 'phone_number' => '0833333333'],
            ['name' => 'Rizky Dwi', 'address' => 'Jl. Cemara No.4', 'phone_number' => '0844444444'],
        ];

        foreach ($customers as $c) {
            Customer::create($c);
        }

        // ================= ORDERS + DETAIL + PAYMENT =================
        $queue = 1;
        foreach (Customer::all() as $customer) {
            $order = Order::create([
                'customer_id' => $customer->id,
                'order_date' => now(),
                'order_date_only' => now()->toDateString(),
                'queue_number' => $queue++,
            ]);

            // pilih 2 menu random per order
            $selectedMenus = Menu::inRandomOrder()->take(2)->get();
            foreach ($selectedMenus as $menu) {
                $qty = rand(1, 3);
                OrderDetail::create([
                    'order_id' => $order->id,
                    'menu_id' => $menu->id,
                    'quantity' => $qty,
                    'subtotal' => $menu->price * $qty,
                ]);
            }

            // bikin payment (default pending)
            Payment::create([
                'order_id' => $order->id,
                'cashier_id' => null,
                'payment_amount' => $order->orderDetails->sum('subtotal'),
                'payment_status' => 'Pending',
                'payment_date' => null,
            ]);
        }
    }
}
