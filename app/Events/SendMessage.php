<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMessage
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

public $conversation;
public $sender_id;
public $receiver_id;
public $message;
    public function __construct($data)
    {
        $this->conversation=$data["conversation"];
        $this->sender_id=$data["sender_id"];
        $this->receiver_id=$data["receiver_id"];
        $this->message=$data["message"];
    }

    // هستقبل البيانات هنا
    public function broadcastWith(){
        return [

            'conversation_id'=>$this->conversation->id,
            'sender_id'=>$this->sender_id,
            'receiver_id'=>$this->receiver_id,
            'message_id'=>$this->message->id,
        ];
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.'. $this->receiver_id),
        ];
    }
}
