<?php

namespace App\Http\Interfaces\Admin;

interface ServiceInterface
{
    public function index();

    public function servicesProvider($provider_id);

    public function store($request);

    public function show($id);

    public function update($request, $id);

    public function delete($id);
}
