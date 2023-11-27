<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\ChatInterface;
use App\Http\Requests\StoreChatRequest;
use App\Http\Requests\StoreMessageRequest;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    private $chatInterface;

    public function __construct(ChatInterface $chatInterface)
    {
        $this->chatInterface = $chatInterface;
    }

    function index()
    {
        return $this->chatInterface->index();
    }

  

    public function store(StoreChatRequest $request)
    {
        return $this->chatInterface->store($request);
    }
    public function storeMessage(StoreMessageRequest $request)
    {
        return $this->chatInterface->storeMessage($request);
    }
    public function show($chat_id)
    {
        return $this->chatInterface->show($chat_id);
    }
}
