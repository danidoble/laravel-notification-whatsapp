<?php

use NotificationChannels\WhatsApp\WhatsAppTextMessage;

test('the notification recipient can be set', function () {
    $message = WhatsAppTextMessage::create()
        ->to('346762014584');

    expect($message->recipient())->toEqual('346762014584');
});

test('the notification message can be set', function () {
    $message = WhatsAppTextMessage::create()
        ->message('Hello, World!');

    expect($message->getMessage())->toEqual('Hello, World!');
});

test('can check if a recipient is set', function () {
    $message = WhatsAppTextMessage::create()
        ->to('346762014584');

    expect($message->hasRecipient())->toBeTrue();
});

test('can return the message type', function () {
    $message = WhatsAppTextMessage::create();

    expect($message->type())->toEqual('text');
});
