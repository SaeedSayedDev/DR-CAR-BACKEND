<?php

namespace App\Http\Interfaces;

interface CarReportInterface
{
    public function show($bookingService);
    public function store($bookingService, $request);
    public function update($bookingService, $request);
    public function delete($bookingService);
    public function userReports();
}
