<?php

namespace App\Http\Interfaces;


interface FavouriteInterface
{


    public function store($request);

    public function delete($favourite_id);
}
