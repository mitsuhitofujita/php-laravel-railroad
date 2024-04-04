<?php

namespace App\Events;

use App\Models\RailwayStationStoreRequest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class RailwayStationStoreRequestCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public RailwayStationStoreRequest $railwayStationStoreRequest)
    {
    }

    /**
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }

    public function getRailwayStationEventStreamId(): int
    {
        return $this->railwayStationStoreRequest['railway_station_event_stream_id'];
    }

    public function getRailwayRouteId(): int
    {
        return $this->railwayStationStoreRequest['railway_route_id'];
    }

    public function getValidFrom(): Carbon
    {
        return $this->railwayStationStoreRequest['valid_from'];
    }

    public function getName(): string
    {
        return $this->railwayStationStoreRequest['name'];
    }

    public function getNickname(): string
    {
        return $this->railwayStationStoreRequest['nickname'];
    }
}
