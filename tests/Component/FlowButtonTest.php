<?php

use NotificationChannels\WhatsApp\Component\FlowButton;

test('quick reply button is valid', function () {
    $button = new FlowButton('token', ['test' => 'example']);
    $expectedValue = [
        'type' => 'button',
        'sub_type' => 'flow',
        'index' => '0',
        'parameters' => [
            [
                'type' => 'action',
                'action' => [
                    'flow_token' => 'token',
                    'flow_action_data' => [
                        'test' => 'example',
                    ],
                ],
            ],
        ],
    ];

    expect($button->toArray())->toEqual($expectedValue);
});
