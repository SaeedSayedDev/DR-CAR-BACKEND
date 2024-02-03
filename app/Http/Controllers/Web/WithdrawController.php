<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Web\WithdrawInterface;
use App\Http\Requests\confirmWithdraw;

class WithdrawController extends Controller
{
    public function __construct(private WithdrawInterface $withdrawInterface)
    {
    }

    public function index()
    {
        return $this->withdrawInterface->index();
    }

    public function show($id)
    {
        return $this->withdrawInterface->show($id);
    }

    public function filterStatus(confirmWithdraw $request)
    {
        return $this->withdrawInterface->filterStatus($request);
    }

    public function updateStatus(confirmWithdraw $request, $id)
    {
        return $this->withdrawInterface->updateStatus($request, $id);
    }
}
