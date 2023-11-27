<?php

namespace App\Traits;

use Illuminate\Support\Facades\Hash;

class UserTrait
{

    public static  $users = [
        ['full_name' => 'customer_name', 'email' => 'customer@gmail.com', 'email_verified_at' => '2023-09-15 15:43:17', 'password' => '$2y$10$1tNORTVDW7Kjk5UWgfOReu68x7VrB4fnvETle0DpII1vvNXE13.uO', 'role_id' => 2],
        ['full_name' => 'garage_name', 'email' => 'garage@gmail.com',  'email_verified_at' => '2023-09-15 15:43:17', 'password' => '$2y$10$1tNORTVDW7Kjk5UWgfOReu68x7VrB4fnvETle0DpII1vvNXE13.uO', 'role_id' => 4]
    ];

    public static  $user_information = [
        ['phone_number' => '01096505009', 'image' => 'image.png', 'address' => 'address', 'short_biography' => 'short_biography', 'phone_verified_at' => '2023-11-17 14:30:43', 'user_id' => 1]
    ];

    public static  $garage_information = [
        ['phone_number' => '01096505009', 'image' => 'image.png', 'address' => 'address', 'short_biography' => 'short_biography', 'phone_verified_at' => '2023-11-17 14:30:43', 'garage_id' => 2, 'garage_type' => 'private']
    ];
}
