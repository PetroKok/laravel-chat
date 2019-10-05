<?php

namespace App\Http\Controllers;

use App\Events\NotifyEvent;
use App\Events\PrivateMessage;
use App\Http\Requests\MessageCreateRequest;
use App\Http\Requests\MessageIndexRequest;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\User;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index(MessageIndexRequest $request){
        $messages = Message::byConversation($request->conversation_id);
        return MessageResource::collection($messages);
    }

    public function create(MessageCreateRequest $request)
    {
        $message = Auth::user()->messageCreate($request->all());
        broadcast(new PrivateMessage($message))->toOthers();
        return new MessageResource($message);
    }
}
