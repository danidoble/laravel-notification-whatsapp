<?php

use NotificationChannels\WhatsApp\Component\Document;
use NotificationChannels\WhatsApp\Exceptions\UnsupportedMediaValue;

test('the document link is a supported document', function () {
    $document = new Document('https://www.netflie.es/document.pdf');
    $expectedValue = [
        'type' => 'document',
        'document' => [
            'link' => 'https://www.netflie.es/document.pdf',
        ],
    ];

    expect($document->toArray())->toEqual($expectedValue);
});

test('the document link is a supported document with filename', function () {
    $document = new Document('https://www.netflie.es/document.pdf', 'my-document');
    $expectedValue = [
        'type' => 'document',
        'document' => [
            'link' => 'https://www.netflie.es/document.pdf',
            'filename' => 'my-document',
        ],
    ];

    expect($document->toArray())->toEqual($expectedValue);
});

test('the document link is a unsupported document', function () {
    expect(function () {
        new Document('https://www.netflie.es/document.doc');
    })->toThrow(UnsupportedMediaValue::class);
});
