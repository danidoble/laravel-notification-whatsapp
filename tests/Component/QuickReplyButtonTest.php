<?php

use NotificationChannels\WhatsApp\Component\QuickReplyButton;

test('quick reply button is valid', function () {
    $button = new QuickReplyButton(['Thanks for your message!', 'We will reply shortly']);
    $expectedValue = [
        'type' => 'button',
        'sub_type' => 'quick_reply',
        'index' => '0',
        'parameters' => [
            [
                'type' => 'payload',
                'payload' => 'Thanks for your message!',
            ],
            [
                'type' => 'payload',
                'payload' => 'We will reply shortly',
            ],
        ],
    ];

    expect($button->toArray())->toEqual($expectedValue);
});
