<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Admin\Service;
use App\Models\GarageData;
use App\Models\GarageInformation;
use App\Models\Slide;
use App\Models\User;
use App\Models\UserInformation;
use App\Models\WinchInformation;
use App\Traits\UserTrait;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = UserTrait::$users;
        foreach ($users as $user) {
            User::create($user);
        }

        $user_informations = UserTrait::$user_information;
        foreach ($user_informations as $user_information) {
            UserInformation::create($user_information);
        }

        $garage_informations = UserTrait::$garage_information;
        foreach ($garage_informations as $garage_information) {
            GarageInformation::create($garage_information);
        }

        $winch_informations = UserTrait::$winch_information;
        foreach ($winch_informations as $winch_information) {
            WinchInformation::create($winch_information);
        }

        $addresses = UserTrait::$addresses;
        foreach ($addresses as $address) {
            Address::create($address);
        }

        $all_garage_data = UserTrait::$garage_data;
        foreach ($all_garage_data as $garage_data) {
            GarageData::create($garage_data);
        }


        $services = UserTrait::$services;
        foreach ($services as $service) {
            Service::create($service);
        }
        $slides = UserTrait::$slides;
        foreach ($slides as $slide) {
            Slide::create($slide);
        }
    }
}
