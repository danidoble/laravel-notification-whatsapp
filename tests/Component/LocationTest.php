<?php

use NotificationChannels\WhatsApp\Component\Location;

test('location is valid', function () {
    $location = new Location(name: 'name', address: 'address', latitude: 1.234567, longitude: 7.891011);

    $expectedValue = [
        'type' => 'location',
        'location' => [
            'latitude' => '1.234567',
            'longitude' => '7.891011',
            'name' => 'name',
            'address' => 'address',
        ],
    ];

    expect($location->toArray())->toEqual($expectedValue);
});
