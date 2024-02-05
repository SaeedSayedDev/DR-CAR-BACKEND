<?php

namespace Database\Seeders;

use App\Models\BookingService;
use App\Models\GarageInformation;
use App\Models\OrderStatus;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class HandelDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $wallets = [
            ['user_id' => 1, 'total_balance' => 0, 'awating_transfer' => 0, 'name' => 'customer_name Wallet'],
            ['user_id' => 2, 'total_balance' => 0, 'awating_transfer' => 0, 'name' => 'garage_name Wallet'],
            ['user_id' => 3, 'total_balance' => 0, 'awating_transfer' => 0, 'name' => 'winch_name Wallet'],
            ['user_id' => 4, 'total_balance' => 0, 'awating_transfer' => 0, 'name' => 'garage2 Wallet'],
            ['user_id' => 5, 'total_balance' => 0, 'awating_transfer' => 0, 'name' => 'garage3 Wallet'],
            ['user_id' => 6, 'total_balance' => 0, 'awating_transfer' => 0, 'name' => 'garage4 Wallet'],
            ['user_id' => 7, 'total_balance' => 0, 'awating_transfer' => 0, 'name' => 'garage5 Wallet'],
        ];
        Wallet::insert($wallets);
    }
}
