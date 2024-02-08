<?php

namespace App\Http\Interfaces;


interface ReviewInterface
{
    
    public function index();
    public function store($request);

    public function update($request, $review_id);

    public function delete($review_id);
}
