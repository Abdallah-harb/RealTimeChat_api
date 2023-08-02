<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use App\Models\User;
use Livewire\Component;

class ChatList extends Component
{
    public $recentConversations , $reciverUser , $select_conversation;

    protected $listeners = ['refresh' => '$refresh'];

   /* public function getListeners()
    {
        return [
            "echo:orders.{$this->orderId},OrderShipped" => 'notifyNewOrder',
        ];
    }*/

    /* public function getUser(Conversation $conversation,$request){ //request = الحاجه اللى عايز اجيبها زى الاسم الايميل
         if($conversation->sender_id == auth()->user()->id){
          $this->reciverUser = User::whereId($conversation->receiver_id);
         }else{
            $this->reciverUser = User::whereId($conversation->sender_id);
         }

         if (isset($request)){
             return $this->reciverUser->$request;
         }

     }*/

    /* select chat to chat with user*/
    public function chatUserSelected(Conversation $conversation , $receiver_id){

        $this->select_conversation = $conversation;
        $this->reciverUser = User::find($receiver_id);
        $this->emitTo('chat.chat-box','loadConversation',$this->select_conversation,$this->reciverUser);
        $this->emitTo('chat.send-message','mainData',$this->select_conversation,$this->reciverUser);

    }
    public function render()
    {
      $this->recentConversations =Conversation::whereSenderId(auth()->user()->id)
        ->orWhere('receiver_id',auth()->user()->id)->orderByDesc('created_at')->get();

        return view('livewire.chat.chat-list');
    }
}
