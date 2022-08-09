<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewChatGroupMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public string $message;
    public string $author;
    public string $chatGroupId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message, $author, $chatGroupId)
    {
        $this->message = $message;
        $this->author = $author;
        $this->chatGroupId = $chatGroupId;
        //
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return ['message' => $this->message, 'author' => $this->author];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('chat-group.' . $this->chatGroupId);
    }
}
