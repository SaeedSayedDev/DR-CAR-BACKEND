<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Web\CommissionInterface;
use App\Http\Requests\Web\CommissionRequest;

class CommissionController extends Controller
{
    public function __construct(private CommissionInterface $commissionInterface)
    {
    }

    public function index()
    {
        return $this->commissionInterface->index();
    }

    public function edit(string $id)
    {
        return $this->commissionInterface->edit($id);
    }

    public function update(CommissionRequest $request, string $id)
    {
        return $this->commissionInterface->update($request, $id);
    }
}
