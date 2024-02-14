<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Web\SlideInterface;
use App\Http\Requests\Web\SlideRequest;

class SlideController extends Controller
{
    public function __construct(private SlideInterface $slideInterface)
    {
    }

    public function index()
    {
        return $this->slideInterface->index();
    }

    public function create()
    {
        return $this->slideInterface->create();
    }

    public function store(SlideRequest $request)
    {
        return $this->slideInterface->store($request);
    }

    public function edit(string $id)
    {
        return $this->slideInterface->edit($id);
    }

    public function update(SlideRequest $request, string $id)
    {
        return $this->slideInterface->update($request, $id);
    }

    public function destroy(string $id)
    {
        return $this->slideInterface->destroy($id);
    }
}
