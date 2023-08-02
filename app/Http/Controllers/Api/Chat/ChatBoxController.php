<?php

namespace App\Http\Controllers\Api\Chat;

use App\Http\Controllers\Controller;
use App\Http\Helper\ResponseHelper;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChatBoxController extends Controller
{
    // show all messages between thr sender & receiver with message Time depend on conversation id
    public function chatBox($conversation_id){
        try {
            // check
            $conversation = Conversation::find($conversation_id);
            if(!$conversation){
                return  ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,"There are error ");
            }
            // get all message on conversation between users
           return $conversation->with('messages')->first();
           /* // get all message on conversation between users
            return $conversation->with(['messages' => function ($q) {
                $q->with('sender', 'receiver');
            }])->first();*/
        }catch (\Exception $exception){
            return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,$exception->getMessage());
        }
    }

}
