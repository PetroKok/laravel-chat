<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class PrivateMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** User id **/
    public $message;

    /**
     * Create a new event instance.
     *
     * @param $user_id
     * @param $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return PresenceChannel
     */
    public function broadcastOn()
    {
        return new PresenceChannel('private.' . $this->message->conversation_id);


        // Here we can broadcast multiple channels with the same event name by using ShouldBroadcast or ShouldBroadcastNow** directly.

//        return [
//            new PrivateChannel('private.' . $this->message->conversation_id),
//            new Channel('notify-event')
//        ];
    }

    public function broadcastWith()
    {
        return [
            'data' => $this->message
        ];
    }

    public function broadcastAs()
    {
        return 'private-listen';
    }
}
