<?php

namespace App\Http\Interfaces;

interface CarLicenseInterface
{
    public function show();
    public function store($request);
    public function update($request);
    public function delete();
}
