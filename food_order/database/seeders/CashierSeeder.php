<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Cashier;

class CashierSeeder extends Seeder
{
    public function run()
    {
        // Ambil dua user kasir (role_id = 2)
        $cashierUsers = User::where('role_id', 2)->take(2)->get();
        $names = ['Atilla', 'Verel'];
        $phones = ['08111111111', '08123456789'];
        $shift = ['Pagi', 'Malam'];
        foreach ($cashierUsers as $i => $user) {
            Cashier::updateOrCreate([
                'user_id' => $user->user_id,
            ], [
                'name' => $names[$i] ?? $user->name,
                'phone_number' => $phones[$i] ?? '08123456789',
                'shift' => $shift[$i] ?? 'Pagi',
            ]);
        }
    }
}
