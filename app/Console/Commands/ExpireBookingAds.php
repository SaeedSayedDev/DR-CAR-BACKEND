<?php

namespace App\Console\Commands;

use App\Models\BookingAd;
use Illuminate\Console\Command;

class ExpireBookingAds extends Command
{
    protected $signature = 'ads:expire';
    protected $description = 'Expire booking ads that have reached the end of their display duration';

    public function handle()
    {
        BookingAd::where('display', true)
            ->where('display_end_date', '<', now())
            ->update(['display' => false]);
        $this->info('Expired booking ads have been updated.');
    }
}
