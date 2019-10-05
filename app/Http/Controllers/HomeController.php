<?php

namespace App\Http\Controllers;

use App\Events\MorningEvent;
use App\Events\NotifyEvent;
use App\Events\PrivateMessage;
use App\Jobs\HomePageAccess;
use App\Models\Conversation;
use App\Models\Message;
use App\Notifications\UserNotification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $conversations = Auth::user()->conversations;
        $users = User::getOthers();
        return view('home', compact('users', 'conversations'));
    }

    public function broadcast()
    {
//        $user->notify(new UserNotification());
//        PrivateMessage::broadcast(Auth::user()->id);
//        event(new NotifyEvent(2));
//        broadcast(new NotifyEvent(3));

        dd(1);
    }

}
