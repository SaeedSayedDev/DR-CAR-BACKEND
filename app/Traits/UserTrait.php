<?php

namespace App\Traits;

class UserTrait
{
    public static  $users = [
        ['full_name' => 'customer_name', 'email' => 'customer@gmail.com', 'email_verified_at' => '2023-09-15 15:43:17', 'password' => '$2y$10$1tNORTVDW7Kjk5UWgfOReu68x7VrB4fnvETle0DpII1vvNXE13.uO', 'role_id' => 2],
        ['full_name' => 'garage_name', 'email' => 'garage@gmail.com',  'email_verified_at' => '2023-09-15 15:43:17', 'password' => '$2y$10$1tNORTVDW7Kjk5UWgfOReu68x7VrB4fnvETle0DpII1vvNXE13.uO', 'role_id' => 4],
        ['full_name' => 'winch_name', 'email' => 'winch@gmail.com',  'email_verified_at' => '2023-09-15 15:43:17', 'password' => '$2y$10$1tNORTVDW7Kjk5UWgfOReu68x7VrB4fnvETle0DpII1vvNXE13.uO', 'role_id' => 3],

        ['full_name' => 'garage2', 'email' => 'garage2@gmail.com',  'email_verified_at' => '2023-09-15 15:43:17', 'password' => '$2y$10$1tNORTVDW7Kjk5UWgfOReu68x7VrB4fnvETle0DpII1vvNXE13.uO', 'role_id' => 4],
        ['full_name' => 'garage3', 'email' => 'garage3@gmail.com',  'email_verified_at' => '2023-09-15 15:43:17', 'password' => '$2y$10$1tNORTVDW7Kjk5UWgfOReu68x7VrB4fnvETle0DpII1vvNXE13.uO', 'role_id' => 4],
        ['full_name' => 'garage4', 'email' => 'garage4@gmail.com',  'email_verified_at' => '2023-09-15 15:43:17', 'password' => '$2y$10$1tNORTVDW7Kjk5UWgfOReu68x7VrB4fnvETle0DpII1vvNXE13.uO', 'role_id' => 4],
        ['full_name' => 'garage5', 'email' => 'garage5@gmail.com',  'email_verified_at' => '2023-09-15 15:43:17', 'password' => '$2y$10$1tNORTVDW7Kjk5UWgfOReu68x7VrB4fnvETle0DpII1vvNXE13.uO', 'role_id' => 4],

        ['full_name' => 'admin', 'email' => 'admin@drcar.website', 'email_verified_at' => '2023-09-15 15:43:17', 'password' => '$2y$10$1tNORTVDW7Kjk5UWgfOReu68x7VrB4fnvETle0DpII1vvNXE13.uO', 'role_id' => 1],
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

    // 4 records [provider => garage_data] [for each garage_data one garage_user]
    public static $providers = [
        [
            'name' => 'drCar Garage',
            'availability_range' => 5,
            'garage_id' => 2,
            'garage_type' => 0, // private
            'tax_id' => 1,
            'address_id' => 1,
            'check_servic_id' => 1
        ],
        [
            'name' => 'AutoCare Center',
            'availability_range' => 8,
            'garage_id' => 4,
            'garage_type' => 1, // company
            'tax_id' => 2,
            'address_id' => 1,
            'check_servic_id' => 1
        ],
        [
            'name' => 'Speedy Repairs',
            'availability_range' => 10,
            'garage_id' => 5,
            'garage_type' => 0, // private
            'tax_id' => 3,
            'address_id' => 1,
            'check_servic_id' => 1
        ],
        [
            'name' => 'ProFix Auto Solutions',
            'availability_range' => 6,
            'garage_id' => 6,
            'garage_type' => 1, // company
            'tax_id' => 4,
            'address_id' => 1,
            'check_servic_id' => 1
        ],
    ];

    // 5 records
    public static $services = [
        [
            'name' => 'Oil Change',
            'desc' => 'Regular oil change services for vehicles.',
            'provider_id' => 1,
            'price' => 100,
            'price_unit' => 1,
            'enable_booking' => true,
        ],
        [
            'name' => 'Body Car',
            'desc' => 'Fix your body car.',
            'provider_id' => 1,
            'price' => 20,
            'price_unit' => 2,
            'enable_booking' => true,
        ],
        [
            'name' => 'Tire Replacement',
            'desc' => 'Professional tire replacement services.',
            'provider_id' => 2,
            'price' => 50,
            'price_unit' => 1,
            'enable_booking' => true,
        ],
        [
            'name' => 'Brake System Check',
            'desc' => 'Thorough check and maintenance of vehicle brake systems.',
            'provider_id' => 2,
            'price' => 30,
            'price_unit' => 2,
            'enable_booking' => true,
        ],
        [
            'name' => 'Wheel Alignment',
            'desc' => 'Precise wheel alignment services for improved vehicle performance.',
            'provider_id' => 3,
            'price' => 75,
            'price_unit' => 1,
            'enable_booking' => true,
        ],
    ];

    // 8 records
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
        [
            'text' => 'slide 3',
            'order' => '3',
            'service_id' => 2,
        ],
        [
            'text' => 'slide 4',
            'order' => '4',
            'service_id' => 2,
        ],
        [
            'text' => 'slide 5',
            'order' => '5',
            'service_id' => 3,
        ],
        [
            'text' => 'slide 6',
            'order' => '6',
            'service_id' => 3,
        ],
        [
            'text' => 'slide 7',
            'order' => '7',
            'service_id' => 4,
        ],
        [
            'text' => 'slide 8',
            'order' => '8',
            'service_id' => 5,
        ],
    ];

    // 2 records
    public static $booking_services = [
        [
            'user_id' => 1,
            'service_id' => 1,
            'payment_amount' => 100,
        ],
        [
            'user_id' => 1,
            'service_id' => 2,
            'payment_amount' => 200,
        ],
    ];

    // 2 records
    public static $booking_winches = [
        [
            'booking_service_id' => 1,
            'address_id' => 1,
            'winch_id' => 1,
            'user_id' => 1,
            'payment_amount' => 150,
        ],
        [
            'booking_service_id' => 2,
            'address_id' => 1,
            'winch_id' => 1,
            'user_id' => 1,
            'payment_amount' => 250,
        ],
    ];
}
