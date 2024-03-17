<?php

use NotificationChannels\WhatsApp\Component\Video;

test('currency is valid', function () {
    $currency = new Video('https://netflie.es/video.webm');
    $expectedValue = [
        'type' => 'video',
        'video' => [
            'link' => 'https://netflie.es/video.webm',
        ],
    ];

    expect($currency->toArray())->toEqual($expectedValue);
});
