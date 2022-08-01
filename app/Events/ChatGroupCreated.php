<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;


class ChatGroupCreated implements ShouldBroadcast
{
    use Dispatchable;

    public string $chatGroupName;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($chatGroupName)
    {
        $this->chatGroupName = $chatGroupName;
        //
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return ['chatGroupName' => $this->chatGroupName];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('global');
    }
}
