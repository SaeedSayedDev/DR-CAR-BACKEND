<?php

namespace App\Services;

class ProviderService
{
    public function reviewAndRate($provider)
    {
        $provider->review = isset($provider->services->review) ? $provider->services->sum('review_count') : 0;
        $provider->rate = isset($provider->services->review) ? $provider->services->sum('review_sum_review_value') /  $provider->review : 0;
        return $provider;
    }
}
