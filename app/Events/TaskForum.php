<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskForum implements ShouldBroadcast 
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $message;
    public $user;
    public $name;
    public $type;
    public $forum;

    /**
     * Create a new event instance.
     */
    public function __construct($message,$user,$name,$type,$forum)
    {
        $this->message = $message;
        $this->user    = $user;
        $this->name    = $name;
        $this->type    = $type;
        $this->forum   = $forum;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('task.forum.'.$this->forum),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'message' => $this->message,
            'user'    => $this->user,
            'name'    => $this->name,
            'type'    => $this->type,
            'forum'   => $this->forum,
        ];
    }

}
