<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Broadcasting\PrivateChannel;
use Livewire\Component;

class ChatBox extends Component
{
    protected  $listeners = ['loadConversation','pushMessage'];
    public $reciever , $reciverUser , $select_conversation , $messages ,$chat_page;

    public function loadConversation(Conversation $conversation ,  User $reciever){
        $this->select_conversation = $conversation;
        $this->reciverUser = $reciever;
        $this->messages = Message::where('conversation_id',$this->select_conversation->id)->get();
    }
    public function getListeners()
    {
        $id=auth()->user()->id;
        $this->chat_page='chat.';
        return [
            "echo-private:$this->chat_page.{$id},SendMessage" => 'broadcastMessage',
        ];
    }
    public function broadcastMessage(){

    }

    public function pushMessage($messageId){
        $newMessage= Message::find($messageId);
        $this->messages->push($newMessage);
    }
    public function render()
    {
        return view('livewire.chat.chat-box');
    }
}
