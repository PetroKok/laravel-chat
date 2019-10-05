<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConversationResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    public function create(Request $request, $user_id)
    {
        $conversation = Auth::user()->conversationCreate($user_id);
        return new ConversationResource($conversation);
    }
}
