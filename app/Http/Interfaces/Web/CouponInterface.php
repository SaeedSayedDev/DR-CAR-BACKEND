<?php

namespace App\Http\Interfaces\Web;

interface CouponInterface
{
    public function index();
    
    public function create();
    
    public function store($request);

    public function edit($id);

    public function update($request, $id);

    public function destroy($id);
}
