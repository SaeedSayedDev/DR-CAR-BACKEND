<?php

namespace App\Services;

class ProviderService
{
    public function reviewAndRate($provider)
    {
        if (isset($provider->services)) {
            if (isset($provider->services->review))
                $provider->review = $provider->services->sum('review_count');
            else
                $provider->review = 0;
        }
        if (isset($provider->services)) {
            if (isset($provider->services->review))
                $provider->rate = $provider->services->sum('review_sum_review_value') /  $provider->review;
            else
                $provider->rate = 0;
        }
        // $provider->review = isset($provider->services->review) ? $provider->services->sum('review_count') : 0;
        // $provider->rate = isset($provider->services->review) ? $provider->services->sum('review_sum_review_value') /  $provider->review : 0;
        return $provider;
    }
}
