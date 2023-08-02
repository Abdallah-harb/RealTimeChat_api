<?php

namespace App\Http\Resources\Chat;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "sender_id" => $this->sender_id,
            "receiver_id" => $this->receiver_id,
            "last_time_message" => $this->last_time_message,
            "last_message" => $this->whenLoaded('messages')
        ];
    }
}
