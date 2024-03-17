<?php

use NotificationChannels\WhatsApp\Component\Currency;
use NotificationChannels\WhatsApp\Component\Document;
use NotificationChannels\WhatsApp\Component\Image;
use NotificationChannels\WhatsApp\Component\QuickReplyButton;
use NotificationChannels\WhatsApp\Component\Text;
use NotificationChannels\WhatsApp\Component\UrlButton;
use NotificationChannels\WhatsApp\Component\Video;
use NotificationChannels\WhatsApp\WhatsAppTemplate;

test('the notification recipient can be set', function () {
    $message = WhatsAppTemplate::create()
        ->to('346762014584');

    expect($message->recipient())->toEqual('346762014584');
});

test('the notification name can be set', function () {
    $message = WhatsAppTemplate::create()
        ->name('invoice_created');

    expect($message->configuredName())->toEqual('invoice_created');
});

test('the notification language can be set', function () {
    $message = WhatsAppTemplate::create()
        ->language('es_fake');

    expect($message->configuredLanguage())->toEqual('es_fake');
});

test('the notification component header can be set', function () {
    $message = WhatsAppTemplate::create()
        ->header(new Currency(10, 'USD'))
        ->header(new Document('https://netflie.es/document.pdf'))
        ->header(new Document('https://netflie.es/document.pdf', 'my-document'))
        ->header(new Video('https://netflie.es/video.webm'));

    $expectedHeader = [
        [
            'type' => 'currency',
            'currency' => ['amount_1000' => 10000, 'code' => 'USD'],
        ],
        [
            'type' => 'document',
            'document' => ['link' => 'https://netflie.es/document.pdf'],
        ],
        [
            'type' => 'document',
            'document' => ['link' => 'https://netflie.es/document.pdf', 'filename' => 'my-document'],
        ],
        [
            'type' => 'video',
            'video' => ['link' => 'https://netflie.es/video.webm'],
        ],
    ];

    expect($message->components()->header())->toEqual($expectedHeader);
});

test('the notification component body can be set', function () {
    $message = WhatsAppTemplate::create()
        ->body(new Text('Mr Jones'))
        ->body(new Image('https://netflie.es/image.png'));

    $expectedHeader = [
        [
            'type' => 'text',
            'text' => 'Mr Jones',
        ],
        [
            'type' => 'image',
            'image' => ['link' => 'https://netflie.es/image.png'],
        ],
    ];

    expect($message->components()->body())->toEqual($expectedHeader);
});

test('the notification component buttons can be set', function () {
    $message = WhatsAppTemplate::create()
        ->buttons(new QuickReplyButton(['Thanks for your message!', 'We will reply shortly']))
        ->buttons(new UrlButton(['event', '01']));

    $expectedButtonsStructure = [
        [
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
        ],
        [
            'type' => 'button',
            'sub_type' => 'url',
            'index' => '1',
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
        ],
    ];

    expect($message->components()->buttons())->toEqual($expectedButtonsStructure);
});
