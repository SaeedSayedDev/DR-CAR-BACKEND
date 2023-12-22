<?php

namespace Database\Seeders;

use App\Models\Admin\Service;
use App\Models\GarageInformation;
use App\Models\Slide;
use App\Models\User;
use App\Models\UserInformation;
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
