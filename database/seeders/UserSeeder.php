<?php

namespace Database\Seeders;

use App\Models\AccountStatement;
use App\Models\Address;
use App\Models\Admin\Service;
use App\Models\BookingService;
use App\Models\BookingWinch;
use App\Models\Coupon;
use App\Models\GarageData;
use App\Models\GarageInformation;
use App\Models\Slide;
use App\Models\User;
use App\Models\UserInformation;
use App\Models\Wallet;
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

        $providers = UserTrait::$providers;
        foreach ($providers as $provider) {
            GarageData::create($provider);
        }

        $services = UserTrait::$services;
        foreach ($services as $service) {
            Service::create($service);
        }

        $slides = UserTrait::$slides;
        foreach ($slides as $slide) {
            Slide::create($slide);
        }

        $booking_services = UserTrait::$booking_services;
        foreach ($booking_services as $booking_service) {
            BookingService::create($booking_service);
        }

        $booking_winches = UserTrait::$booking_winches;
        foreach ($booking_winches as $booking_winch) {
            BookingWinch::create($booking_winch);
        }
        
        $coupons = UserTrait::$coupons;
        foreach ($coupons as $coupon) {
            Coupon::create($coupon);
        }
        
        $wallets = UserTrait::$wallets;
        foreach ($wallets as $wallet) {
            Wallet::create($wallet);
        }
        
        $walletTransactions = UserTrait::$walletTransactions;
        foreach ($walletTransactions as $walletTransaction) {
            AccountStatement::create($walletTransaction);
        }
    }
}
