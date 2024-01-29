<?php

namespace App\Http\Interfaces\Web;

interface CommissionInterface
{
    public function index();

    public function edit($id);

    public function update($request, $id);
}
