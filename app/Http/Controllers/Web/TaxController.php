<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Web\TaxInterface;
use App\Http\Requests\Web\TaxRequest;

class TaxController extends Controller
{
    public function __construct(private TaxInterface $taxInterface)
    {
    }

    public function index()
    {
        return $this->taxInterface->index();
    }

    // public function create()
    // {
    //     return $this->taxInterface->create();
    // }

    // public function store(TaxRequest $request)
    // {
    //     return $this->taxInterface->store($request);
    // }

    public function edit(string $id)
    {
        return $this->taxInterface->edit($id);
    }

    public function update(TaxRequest $request, string $id)
    {
        return $this->taxInterface->update($request, $id);
    }

    // public function destroy(string $id)
    // {
    //     return $this->taxInterface->destroy($id);
    // }
}
