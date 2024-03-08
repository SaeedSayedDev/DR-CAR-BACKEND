<?php

namespace App\Http\Interfaces;

interface CarReportInterface
{
    public function index($bookingService);
    public function show($carReport);
    public function store($bookingService, $request);
    public function update($bookingService, $request);
    public function delete($bookingService);
    public function userReports();
}
