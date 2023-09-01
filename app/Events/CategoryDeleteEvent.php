<?php

namespace App\Events;

use App\Models\CategoryCommand;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CategoryDeleteEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    private $category;
    public function getCategory()
    {
        return $this->category;
    }
    /**
     * Create a new event instance.
     */
    public function __construct(CategoryCommand $category)
    {
        $this->category = $category;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
