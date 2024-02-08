<?php

namespace App\Services;


use App\Models\ProfileBusiness;
use App\Models\setting\Country;
use AmrShawky\LaravelCurrency\Facade\Currency;
use Illuminate\Support\Facades\Http;

class ConvertCurrencyService
{


    function convertAmountFromAEDToUSA($amount)
    {
        return $amount / 3.67;
        $response = Http::withHeaders([
            'apikey' => env('FIXER_API_KEY'),
        ])->get('https://api.apilayer.com/fixer/convert', [
            'from' => 'AED',
            'to' => 'USD',
            'amount' => $amount,
            'date' =>  date('Y-m-d'),
        ]);
        return $response['result'];
    }
    function convertAmountFromUSDToAED($amount)
    {

        $apiUrl = "https://api.fixer.io/latest?access_key=" . env('FIXER_API_KEY');

        $response = Http::withHeaders([
            'apikey' => env('FIXER_API_KEY'),
        ])->get('https://api.apilayer.com/fixer/convert', [
            'from' => 'USD',
            'to' => 'AED',
            'amount' => $amount,
            'date' =>  date('Y-m-d'),
        ]);
        return $response['result'];
    }
}
