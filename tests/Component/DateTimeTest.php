<?php

use NotificationChannels\WhatsApp\Component\DateTime;

test('currency is valid', function () {
    $dateTime = new \DateTimeImmutable();
    $currency = new DateTime($dateTime);
    $expectedValue = [
        'type' => 'date_time',
        'date_time' => [
            'fallback_value' => $dateTime->format('Y-m-d H:i:s'),
        ],
    ];

    expect($currency->toArray())->toEqual($expectedValue);
});
