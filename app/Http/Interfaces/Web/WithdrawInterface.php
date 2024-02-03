<?php

namespace App\Http\Interfaces\Web;

interface WithdrawInterface
{
    public function index();

    public function show($id);

    public function filterStatus($request);

    public function updateStatus($request, $id);
}
