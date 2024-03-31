<?php

namespace App\Events;

use App\Models\RailwayRouteStoreRequest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class RailwayRouteStoreRequestCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public RailwayRouteStoreRequest $railwayRouteStoreRequest)
    {
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

    public function getRailwayRouteEventStreamId(): int
    {
        return $this->railwayRouteStoreRequest['railway_route_event_stream_id'];
    }

    public function getRailwayProviderId(): int
    {
        return $this->railwayRouteStoreRequest['railway_provider_id'];
    }

    public function getValidFrom(): Carbon
    {
        return $this->railwayRouteStoreRequest['valid_from'];
    }

    public function getName(): string
    {
        return $this->railwayRouteStoreRequest['name'];
    }
}
