<?php

namespace App\Http\Interfaces;


interface OptionInterface
{

    public function store($request);
    public function update($request ,$option_id);
}
