<?php

namespace App\Http\Interfaces;

interface AddressInterface
{
    public function index();

    public function store($request);

    public function update($request, $id);

    public function delete($id);
}