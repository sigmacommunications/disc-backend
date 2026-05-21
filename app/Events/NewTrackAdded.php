<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;  // ✅ YEH HONA CHAHIYE
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewTrackAdded implements ShouldBroadcastNow    // ✅ YEH INTERFACE
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $artistName;
    public $trackName;
    public $type;
    public $message;

    public function __construct($userId, $artistName, $trackName,$type)
    {
        $this->userId = $userId;
        $this->artistName = $artistName;
        $this->trackName = $trackName;
        $this->type = $type;
        $this->message = "$artistName added new track: $trackName";
    }

    public function broadcastOn()
    {
        // Public channel for testing (without auth)
        return new Channel('new-track-channel-'.$this->userId);
    }
    
    public function broadcastAs()
    {
        return 'new-track';
    }
    
    public function broadcastWith()
    {
        \Log::info('Broadcasting event', [
            'channel' => $this->broadcastOn(),
            'user_id' => $this->userId
        ]);
        
        return [
            'user_id' => $this->userId,
            'artist_name' => $this->artistName,
            'track_name' => $this->trackName,
            'type' => $this->type,
            'message' => $this->message
        ];
    }
}