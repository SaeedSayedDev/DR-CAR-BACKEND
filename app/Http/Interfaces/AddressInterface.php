<?php

namespace App\Http\Interfaces;

interface AddressInterface
{
    public function index();

    public function store($request);
}
