<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\AddressInterface;
use App\Http\Requests\AddressRequset;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    //
    public function __construct(private AddressInterface $addressInterface)
    {
    }
    public function index()
    {
        return $this->addressInterface->index();
    }

    public function store(AddressRequset $request)
    {
        return $this->addressInterface->store($request);
    }

    public function update(AddressRequset $request, $id)
    {
        return $this->addressInterface->store($request, $id);
    }
    public function delete($id)
    {
        return $this->addressInterface->store($id);
    }
}
