<?php

namespace App\Http\Resources\Chat;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            "conversation_id" => $this->conversation_id,
            "sender_id" => $this->sender_id,
            "receiver_id" => $this->receiver_id,
            "read" => $this->read,
            "message" => $this->body,
        ];
    }
}
