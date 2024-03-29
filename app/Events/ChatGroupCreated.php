<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;


class ChatGroupCreated implements ShouldBroadcast
{
    use Dispatchable,InteractsWithSockets;

    public string $chatGroupName;
    public string $chatGroupId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($chatGroupName, $chatGroupId)
    {
        $this->chatGroupName = $chatGroupName;
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
        return ['chatGroupName' => $this->chatGroupName, 'chatGroupId' => $this->chatGroupId];
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
