<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\FavouriteInterface;
use App\Models\Favourite;
use App\Models\User;

class FavouriteRepository implements FavouriteInterface
{
    public function index()
    {
        $user =  auth()->user();
        $favourites =Favourite::where('user_id', $user->id)->with('service.media')->get();
        return response()->json([
            'success' => true,
            'data' => $favourites,
            "message" => "Favourite retrieved successfully"
        ]);
    }

    //favourite
    public function store($request)
    {
        $user =  auth()->user();
        if ($user->role_id == 2) {
            Favourite::Create([
                'user_id' => $user->id,
                'service_id' => $request->service_id,
            ]);
            return response()->json(['message' => 'sucsess']);
        }
        return response()->json(['message' => 'only user can add favourite to service'], 404);
    }

    public function delete($favourite_id)
    {
        $user_id = auth()->user()->id;
        Favourite::where('user_id', $user_id)->findOrFail($favourite_id)->delete();
        return response()->json(['message' => 'sucsess']);
    }
}
