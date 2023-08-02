<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $id,$conversation_id,$sender_id,$receiver_id,$read,$body;
    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->conversation_id = $data['conversation_id'];
        $this->sender_id = $data['sender_id'];
        $this->receiver_id = $data['receiver_id'];
        $this->read = $data['read'];
        $this->body = $data['body'];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */

    //method is used to define the data that will be sent with the event when it is broadcasted

    public function broadcastWith(){
        return [
            "id" => $this->id,
            "conversation_id"=>$this->conversation_id,
            "sender_id"=>$this->sender_id,
            "receiver_id"=>$this->receiver_id,
            "read"=>$this->read,
            "body"=>$this->body,
        ];

    }
        //channel names
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.'.$this->receiver_id),
        ];
    }

    public function broadcastAs()
    {
        return 'message'; // You can change 'message' to the desired broadcast name
    }
}
