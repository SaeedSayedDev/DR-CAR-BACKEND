<?php

namespace App\Services;

class AddressService
{
    public function calDistance($lat1, $lon1, $lat2, $lon2)
    {

        // dump($lat1);
        // dump($lon1);
        // dump($lat2);
        // dd($lon2);
        $earthRadius = 6371; // Radius of the Earth in kilometers

        // Convert latitude and longitude from degrees to radians
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);
        // Haversine formula
        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;
        $a = sin($dlat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($dlon / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        // Calculate distance
        $distance = $earthRadius * $c;

        return $distance;
    }
  
}
