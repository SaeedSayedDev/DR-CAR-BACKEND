<?php

namespace App\Http\Interfaces;

interface CarReportInterface
{
    public function showReports($bookingService);
    public function store($bookingService, $request);
    public function update($bookingService, $request);
    public function delete($bookingService);
    public function userReports();
    public function get_all_reports_for_garage();

}
