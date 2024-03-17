<?php

use NotificationChannels\WhatsApp\Component\Currency;

test('currency is valid', function () {
    $amount = 10.25;
    // 10,25 €
    $currency = new Currency($amount);
    $expectedValue = [
        'type' => 'currency',
        'currency' => [
            'amount_1000' => 10250,
            'code' => 'EUR',
        ],
    ];

    expect($currency->toArray())->toEqual($expectedValue);
});
