<?php

namespace App\Http\Interfaces;

interface AccountInterface
{
    public function show($id);

    public function update($request, $id);

    public function delete($id);
}
