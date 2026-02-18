<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message->load('user');
    }

    public function broadcastOn()
    {
        return new PrivateChannel('conversation.' . $this->message->conversation_id);
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->message->id,
            'body' => $this->message->body,
            'file_path' => $this->message->file_path,
            'file_name' => $this->message->file_name,
            'file_type' => $this->message->file_type,
            'file_size' => $this->message->file_size,
            'file_url' => $this->message->file_url,
            'file_icon' => $this->message->file_icon,
            'formatted_size' => $this->message->formatted_size,
            'user_id' => $this->message->user_id,
            'user_name' => $this->message->user->name,
            'created_at' => $this->message->created_at->toISOString(),
        ];
    }
}