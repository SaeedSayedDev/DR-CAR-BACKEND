<?php

namespace App\Services;

class AddressService
{
    public function calDistance($lat1, $lon1, $lat2, $lon2)
    {
        // $lat1 = 29.817446;
        // $lon1 = 31.238099;
        // $lat2 = 29.472148;
        // $lon2 = 30.880290;
        $apiKey = 'AIzaSyBss8QIwWZ9Q3E-ziCVDsQOOvYWI3tDPfA';

        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?destinations=$lat2,$lon2&origins=$lat1,$lon1&key=$apiKey";
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        // return $data;
        if ($data['status'] == 'OK') {
            return $data['rows'][0]['elements'][0]['distance']['value'] / 1000; // Distance in meters
        } else {
            return false;
        }

        // // dump($lat1);
        // // dump($lon1);
        // // dump($lat2);
        // // dd($lon2);
        // $earthRadius = 6371; // Radius of the Earth in kilometers

        // // Convert latitude and longitude from degrees to radians
        // $lat1 = deg2rad($lat1);
        // $lon1 = deg2rad($lon1);
        // $lat2 = deg2rad($lat2);
        // $lon2 = deg2rad($lon2);
        // // Haversine formula
        // $dlat = $lat2 - $lat1;
        // $dlon = $lon2 - $lon1;
        // $a = sin($dlat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($dlon / 2) ** 2;
        // $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        // // Calculate distance
        // $distance = $earthRadius * $c;

        // return $distance;
    }
}
