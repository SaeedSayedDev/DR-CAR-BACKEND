<?php

namespace App\Traits;

use Illuminate\Support\Facades\Hash;

class UserTrait
{

    public static  $users = [
        ['full_name' => 'customer_name', 'email' => 'customer@gmail.com', 'email_verified_at' => '2023-09-15 15:43:17', 'password' => '$2y$10$1tNORTVDW7Kjk5UWgfOReu68x7VrB4fnvETle0DpII1vvNXE13.uO', 'role_id' => 2],
        ['full_name' => 'garage_name', 'email' => 'garage@gmail.com',  'email_verified_at' => '2023-09-15 15:43:17', 'password' => '$2y$10$1tNORTVDW7Kjk5UWgfOReu68x7VrB4fnvETle0DpII1vvNXE13.uO', 'role_id' => 4],
        ['full_name' => 'winch_name', 'email' => 'winch@gmail.com',  'email_verified_at' => '2023-09-15 15:43:17', 'password' => '$2y$10$1tNORTVDW7Kjk5UWgfOReu68x7VrB4fnvETle0DpII1vvNXE13.uO', 'role_id' => 3],
        ['full_name' => 'admin_name', 'email' => 'admin@gmail.com', 'email_verified_at' => '2023-09-15 15:43:17', 'password' => '$2y$10$1tNORTVDW7Kjk5UWgfOReu68x7VrB4fnvETle0DpII1vvNXE13.uO', 'role_id' => 1],
    ];

    public static  $user_information = [
        ['phone_number' => '01096505009', 'address' => 'address', 'short_biography' => 'short_biography', 'phone_verified_at' => '2023-11-17 14:30:43', 'user_id' => 1]
    ];

    public static  $garage_information = [
        ['phone_number' => '01096505009', 'address' => 'address', 'short_biography' => 'short_biography', 'phone_verified_at' => '2023-11-17 14:30:43', 'garage_id' => 2]
    ];

    public static  $winch_information = [
        ['phone_number' => '010965050093', 'address' => 'address', 'short_biography' => 'short_biography', 'phone_verified_at' => '2023-11-17 14:30:43', 'winch_id' => 3]
    ];
    public static  $addresses = [
        ['address' => 'السياحى كوبري المثلث مدخل هرم, المريوطيه طريق, السياحي, الهرم، محافظة الجيزة 12919', 'latitude' => 29.817446293635328, 'longitude' => 31.23809960860361, 'user_id' => 2]
    ];
    public static  $garage_data = [
        ['name' => 'drCar Garage', 'availability_range' => '5', 'garage_id' => 2, 'garage_type' => 0, 'tax_id' => 1, 'address_id' => 1]
    ];
    public static $services = [
        [
            'name' => 'Oil Change',
            'desc' => 'Regular oil change services for vehicles.',
            'provider_id' => 1,
            'price' => 100,
            'price_unit' => 1,
            'enable_booking' => true
        ],
        [
            'name' => 'Body Car',
            'desc' => 'fix your body car.',
            'provider_id' => 1,
            'price' => 20,
            'price_unit' => 2,
            'enable_booking' => true

        ]

    ];

    public static $slides = [
        [
            'text' => 'slide 1',
            'order' => '1',
            'service_id' => 1,
        ],
        [
            'text' => 'slide 2',
            'order' => '2',
            'service_id' => 1,
        ],
    ];
}
