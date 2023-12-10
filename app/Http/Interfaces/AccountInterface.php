<?php

namespace App\Http\Interfaces;

interface AccountInterface
{
    public function show();

    public function update($request);

    public function delete();
}
