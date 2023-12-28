<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\AddressInterface;
use App\Models\Address;

class AddressRepository implements AddressInterface
{
    public function index()
    {
        $user = auth()->user();
        $data = $this->checkRole($user);
        $address = Address::where('type_id', $data['type_id'])->where('type_name', $data['type_name'])->get();

        return response()->json(['data' => $address]);
    }

    public function store($request)
    {
        $user = auth()->user();
        $data = $request->all();
        $data = $this->checkRole($user, $data);
        if ($user->role_id == 4) {
            $data['type_name'] = 'garage';
            $data['type_id'] = $user->garage_data->id;
        }
        $data = Address::updateOrCreate(['type_name' => $data['type_name'], 'type_id' => $data['type_id'],], $data);
        return response()->json(["success" => true, 'data' => $data, "message" => "Address Updated successfully"]);
    }

    public function checkRole($user, $data = null)
    {
        if ($user->role_id == 4) {
            $data['type_name'] = 'garage';
            $data['type_id'] = $user->garage_data->id;
        } else {
            $data['type_name'] = 'user';
            $data['type_id'] = $user->id;
        }
        return $data;
    }
}
