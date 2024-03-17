<?php

use NotificationChannels\WhatsApp\Component\Image;

test('currency is valid', function () {
    $currency = new Image('https://netflie.es/image.png');
    $expectedValue = [
        'type' => 'image',
        'image' => [
            'link' => 'https://netflie.es/image.png',
        ],
    ];

    expect($currency->toArray())->toEqual($expectedValue);
});
