<?php

namespace Database\Seeders;

use App\Models\BookingService;
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
        $data = [
            [
                "status" => "Received",
            ],
            [
                "status" => "In Progress",
            ],
            [
                "status" => "On the Way",

            ],
            [
                "status" => "Accepted",

            ],
            [
                "status" => "Ready",

            ],
            [
                "status" => "Done",

            ],
            [
                "status" => "Failed",

            ]
        ];
        OrderStatus::insert($data);
        $bookingServicesOld = BookingService::get();
        Artisan::call('migrate');

        $bookingServices = BookingService::get();

        for ($i = 0; $i < count($bookingServices); $i++) {
            $bookingServices[$i]->update(['order_status_id' => $bookingServicesOld[$i]->order_status_id]);
        }
    }
}