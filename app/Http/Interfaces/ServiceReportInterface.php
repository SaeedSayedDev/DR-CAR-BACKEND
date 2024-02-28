<?php

namespace App\Http\Interfaces;

interface ServiceReportInterface
{
    public function store($bookingService, $request);
    public function update($bookingService, $request);
    public function delete($bookingService);
    public function historyGarage($carLicense);
    public function historyUser();
}
