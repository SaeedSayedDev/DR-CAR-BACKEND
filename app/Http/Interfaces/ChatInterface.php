<?php

namespace App\Http\Interfaces;


interface ChatInterface
{
    public function index();

    public function store($request);
    public function storeMessage($request);
    public function show($chat_id);
}
