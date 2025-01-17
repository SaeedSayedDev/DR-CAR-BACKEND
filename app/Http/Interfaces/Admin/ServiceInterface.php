<?php

namespace App\Http\Interfaces\Admin;

interface ServiceInterface
{
    public function index($filter_key, $item_id, $type_category_or_subCategory);

    public function indexGarage();

    public function servicesProvider($provider_id);

    public function store($request);

    public function show($id);

    public function update($request, $id);

    public function delete($id);
    public function recommended();
}
