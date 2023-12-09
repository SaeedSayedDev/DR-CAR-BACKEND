<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\FavouriteInterface;
use App\Http\Requests\FavouriteRequest;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{

    public function __construct(private FavouriteInterface $favouriteInterface)
    {
    }

    // Favourite
    public function store(FavouriteRequest $request)
    {
        return $this->favouriteInterface->store($request);
    }
    public function delete($favourite_id)
    {
        return $this->favouriteInterface->delete($favourite_id);
    }
}
