<?php

namespace App\Events;

use App\Models\RailwayStationUpdateRequest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class RailwayStationUpdateRequestCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public RailwayStationUpdateRequest $railwayStationUpdateRequest)
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

    public function getRailwayStationId(): int
    {
        return $this->railwayStationUpdateRequest['railway_station_id'];
    }

    public function getRailwayRouteId(): int
    {
        return $this->railwayStationUpdateRequest['railway_route_id'];
    }

    public function getValidFrom(): Carbon
    {
        return $this->railwayStationUpdateRequest['valid_from'];
    }

    public function getName(): string
    {
        return $this->railwayStationUpdateRequest['name'];
    }

    public function getNickname(): string
    {
        return $this->railwayStationUpdateRequest['nickname'];
    }
}
