<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Web\UserInterface;
use App\Http\Requests\Web\UserRequest;

class UserController extends Controller
{
    public function __construct(private UserInterface $userInterface)
    {
    }

    public function index()
    {
        return $this->userInterface->index();
    }

    public function create()
    {
        return $this->userInterface->create();
    }

    public function store(UserRequest $request)
    {
        return $this->userInterface->store($request);
    }

    public function show($id)
    {
        return $this->userInterface->show($id);
    }

    public function edit($id)
    {
        return $this->userInterface->edit($id);
    }

    public function update(UserRequest $request, $id)
    {
        return $this->userInterface->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->userInterface->destroy($id);
    }
}
