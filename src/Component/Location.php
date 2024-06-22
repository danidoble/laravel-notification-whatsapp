<?php

namespace NotificationChannels\WhatsApp\Component;

class Location extends Component
{
    public function __construct(
        protected string $name,
        protected string $address,
        protected float $latitude,
        protected float $longitude
    ) {}

    public function toArray(): array
    {
        return [
            'type' => 'location',
            'location' => [
                'latitude' => (string) $this->latitude,
                'longitude' => (string) $this->longitude,
                'name' => $this->name,
                'address' => $this->address,
            ],
        ];
    }
}
