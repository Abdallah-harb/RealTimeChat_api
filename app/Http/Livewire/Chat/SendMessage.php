<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Livewire\Component;

class SendMessage extends Component
{
    public $reciever , $reciverUser , $select_conversation,$body,$createMessage;

    protected $listeners = ['mainData'];

    public function mainData(Conversation $conversation ,  User $reciever){
        $this->select_conversation = $conversation;
        $this->reciverUser = $reciever;
    }

    public function sendMessage(){
        if ($this->body == null){
            return null;
        }
      $this->createMessage = Message::create([
          "conversation_id" => $this->select_conversation->id,
          "sender_id" => auth()->user()->id,
          "receiver_id" => $this->reciverUser->id,
          "body" => $this->body,
      ]);
        $this->select_conversation->last_time_message=$this->createMessage->created_at;
        $this->select_conversation->save();
        $this->reset('body');

        //event to push message
        $this->emitTo('chat.chat-box','pushMessage',$this->createMessage->id);
        $this->emitTo('chat.chat-list','refresh');
        $this->emitSelf('realTimeMessage');

    }
    public function realTimeMessage(){
        $data['conversation'] = $this->select_conversation->id;
        $data['sender_id'] = auth()->user()->id;
        $data['receiver_id'] =$this->reciverUser->id;
        $data['message'] =$this->createMessage ;
        broadcast(new \App\Events\SendMessage($data));
    }
    public function render()
    {
        return view('livewire.chat.send-message');
    }
}
