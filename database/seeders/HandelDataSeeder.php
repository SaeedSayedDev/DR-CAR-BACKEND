<?php

namespace Database\Seeders;

use App\Models\BookingService;
use App\Models\GarageInformation;
use App\Models\OrderStatus;
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
        $garage_informations = [
            ['phone_number' => '01096505007', 'address' => 'address_3', 'short_biography' => 'short_biography_3', 'phone_verified_at' => '2023-11-17 14:30:43', 'garage_id' => 5],
            ['phone_number' => '01096505006', 'address' => 'address_4', 'short_biography' => 'short_biography_4', 'phone_verified_at' => '2023-11-17 14:30:43', 'garage_id' => 6],
            ['phone_number' => '01096505005', 'address' => 'address_5', 'short_biography' => 'short_biography_5', 'phone_verified_at' => '2023-11-17 14:30:43', 'garage_id' => 7]
        ];
        foreach ($garage_informations as $garage_information) {
            GarageInformation::create($garage_information);
        }
    }
}
