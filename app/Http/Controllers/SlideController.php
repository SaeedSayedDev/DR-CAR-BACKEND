<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\SlideInterface;
use App\Http\Requests\SlideRequest;

class SlideController extends Controller
{
    public function __construct(private SlideInterface $slideInterface)
    {
    }

    public function index()
    {
        return $this->slideInterface->index();
    }

    public function store(SlideRequest $request)
    {
        return $this->slideInterface->store($request);
    }

    public function show(string $id)
    {
        return $this->slideInterface->show($id);
    }

    public function update(SlideRequest $request, string $id)
    {
        return $this->slideInterface->update($request, $id);
    }

    public function delete(string $id)
    {
        return $this->slideInterface->delete($id);
    }
}
