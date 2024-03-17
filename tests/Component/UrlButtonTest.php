<?php

use NotificationChannels\WhatsApp\Component\UrlButton;

test('url button is valid', function () {
    $button = new UrlButton(['event', '01']);
    $expectedValue = [
        'type' => 'button',
        'sub_type' => 'url',
        'index' => '0',
        'parameters' => [
            [
                'type' => 'text',
                'text' => 'event',
            ],
            [
                'type' => 'text',
                'text' => '01',
            ],
        ],
    ];

    expect($button->toArray())->toEqual($expectedValue);
});
