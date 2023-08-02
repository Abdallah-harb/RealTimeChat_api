<?php

namespace App\Http\Controllers\Api\Chat;

use App\Http\Controllers\Controller;
use App\Http\Helper\ResponseHelper;
use App\Http\Resources\Chat\ChatListResource;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ChatListController extends Controller
{
    // all conversation of user and last message on conversation

    public function allConvesation(){
        try {
              $recentConversation = Conversation::where(function ($query) {
                 $query->where('sender_id', auth('api')->user()->id)
                     ->orWhere('receiver_id', auth('api')->user()->id);
             })
                 ->with(['messages' => function ($query) {
                     $query->select('messages.conversation_id', 'messages.body')
                         ->join(DB::raw('(select conversation_id, max(id) as max_id from messages group by conversation_id) as t'), function ($q) {
                             $q->on('messages.conversation_id', '=', 't.conversation_id')
                                 ->on('messages.id', '=', 't.max_id');
                         });
                 }])
                 ->orderByDesc('updated_at')
                 ->get();
                return ResponseHelper::sendResponseSuccess(ChatListResource::collection($recentConversation));
        }catch (\Exception $exception){
            return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,$exception->getMessage());
        }
    }

    // delete conversation



}
