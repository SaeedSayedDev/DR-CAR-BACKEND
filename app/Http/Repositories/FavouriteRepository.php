<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\FavouriteInterface;
use App\Models\Admin\Service;
use App\Models\Favourite;
use App\Models\User;

class FavouriteRepository implements FavouriteInterface
{
    public function index()
    {
        $user =  auth()->user();
        $favourites = Favourite::where('user_id', $user->id)
            ->with('service', function ($query) {
                $query->with('media', 'items')
                    ->withSum('review', 'review_value')
                    ->withCount('review');
            })->get()
            ->map(function ($favourite) {
                $favourite->service->rate = $favourite->service->review_count > 0 ? $favourite->service->review_sum_review_value / $favourite->service->review_count : 0;
                return  $favourite;
            });
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

    public function delete($service_id)
    {
        $user_id = auth()->user()->id;
        $service = Service::whereHas('favourite_user')->findOrFail($service_id);
        $service->favourite_user->delete();
        return response()->json(['message' => 'sucsess']);
    }
}
