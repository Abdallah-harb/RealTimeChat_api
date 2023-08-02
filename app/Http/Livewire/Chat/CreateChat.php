<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CreateChat extends Component
{
    public $users;
    public function createConversation($receiver_id){
        DB::beginTransaction();
        try {
            $checkConversation = Conversation::where('sender_id',auth()->user()->id)->where('receiver_id',$receiver_id)
                ->orWhere('receiver_id',auth()->user()->id)->orWhere('sender_id',$receiver_id)->get();
           if($checkConversation->isEmpty()){
               $conversation = Conversation::create([
                   "sender_id" =>  auth()->user()->id,
                   "receiver_id" => $receiver_id
               ]);
               $message = Message::create([
                   "conversation_id" => $conversation->id,
                   "sender_id" =>  auth()->user()->id,
                   "receiver_id" => $receiver_id,
                   "body" => 'السلام عليكم',
               ]);
               DB::commit();
               dd($message);
           }else{
               dd('Conversation Exist');
           }

        }catch (\Exception $ex){
            DB::rollBack();
           dd ($ex->getMessage());
        }
    }
    public function render()
    {
        $this->users = User::where('id', '<>', Auth::user()->id)->get();
        return view('livewire.chat.create-chat')->extends('Dashboard.layouts.master');
    }
}
