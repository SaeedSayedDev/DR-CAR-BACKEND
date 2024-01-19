<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\AddressInterface;
use App\Models\Address;

class AddressRepository implements AddressInterface
{
    public function index()
    {
        $user = auth()->user();
        $address = Address::where('user_id', $user->id)->get();

        return response()->json(['data' => $address]);
    }

    public function store($request)
    {
        $user = auth()->user();
        $data = $request->all();
        $data['user_id'] = $user->id;
        $data = $user->role_id == 4 ? Address::create($data) :
            Address::updateOrCreate(['user_id' => $user->id], $data);
        return response()->json(["success" => true, 'data' => $data, "message" => "Address Updated successfully"]);
    }

    public function checkRole($user, $data = null)
    {
        if ($user->role_id == 4) {
            $data['type_name'] = 'garage';
            $data['type_id'] = $user->garage_data ? $user->garage_data->id : -1;
        } else {
            $data['type_name'] = 'user';
            $data['type_id'] = $user->id;
        }
        return $data;
    }
}
