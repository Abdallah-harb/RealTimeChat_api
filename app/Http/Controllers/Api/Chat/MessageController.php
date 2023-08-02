<?php

namespace App\Http\Controllers\Api\Chat;

use App\Events\MessageEvent;
use App\Http\Controllers\Controller;
use App\Http\Helper\ResponseHelper;
use App\Http\Requests\Chat\MessageRequest;
use App\Http\Resources\Chat\MessageResource;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
   public function startChat(MessageRequest $request){
       DB::beginTransaction();
       try {
           // start chat between user
           /*
            * 1 - create conversion [ check if conversation exists between two users not create it ]
            * 2- create message [ validate it ]
            *  */
           $senderId = auth('api')->user()->id;
           $receiverId = $request->user_id;
           $checkConversationExists = Conversation::where('sender_id',$senderId)->where('receiver_id',$receiverId)
               ->orWhere('receiver_id',$senderId)->orWhere('sender_id',$receiverId)->first();
           if($checkConversationExists){
               $message = Message::create([
                   "conversation_id" => $checkConversationExists->id,
                   "sender_id" => auth('api')->user()->id,
                   "receiver_id" => $request->user_id,
                   "body" => $request->body
               ]);
               $checkConversationExists->last_time_message =  $message->created_at;
               $checkConversationExists->save();
               // data to send in event
               $data = [
                    "id" => $message->id,
                    "conversation_id"=>$checkConversationExists->id ,
                    "sender_id"=>auth('api')->user()->id,
                    "receiver_id"=>$request->user_id,
                    "read"=>$message->read,
                    "body"=>$request->body
               ];
               event(new MessageEvent($data));
           }else{
               $conversation = Conversation::create([
                   "sender_id" => auth('api')->user()->id,
                   "receiver_id" => $request->user_id
               ]);
               // create new message
               $message = Message::create([
                   "conversation_id" => $conversation->id,
                   "sender_id" => auth('api')->user()->id,
                   "receiver_id" => $request->user_id,
                   "body" => $request->body
               ]);
               $conversation->last_time_message =  $message->created_at;
               $conversation->save();
               $data = [
                   "id" => $message->id,
                   "conversation_id"=>$checkConversationExists->id ,
                   "sender_id"=>auth('api')->user()->id,
                   "receiver_id"=>$request->user_id,
                   "read"=>$message->read,
                   "body"=>$request->body
               ];
               event(new MessageEvent($data));
           }
            DB::commit();
           return ResponseHelper::sendResponseSuccess(new MessageResource($message));
       }catch (\Exception $exception){
           DB::rollBack();
           return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,$exception->getMessage());
       }
   }


    public function destroy(string $id)
    {
        //
    }


}
