<?php

use NotificationChannels\WhatsApp\Component;

it('can return a currency component', function () {
    $component = Component::currency(10, 'EUR');

    expect($component)->toBeInstanceOf(Component\Currency::class);
});

it('can return a datetime component', function () {
    $component = Component::dateTime(new \DateTimeImmutable());

    expect($component)->toBeInstanceOf(Component\DateTime::class);
});

it('can return a document component', function () {
    $component = Component::document('https://www.netflie.es/my_document.pdf');

    expect($component)->toBeInstanceOf(Component\Document::class);
});

it('can return an image component', function () {
    $component = Component::image('https://www.netflie.es/my_image.png');

    expect($component)->toBeInstanceOf(Component\Image::class);
});

it('can return a text component', function () {
    $component = Component::text('Hey there!');

    expect($component)->toBeInstanceOf(Component\Text::class);
});

it('can return a video component', function () {
    $component = Component::video('https://www.netflie.es/my_image.webm');

    expect($component)->toBeInstanceOf(Component\Video::class);
});

it('can return a url button component', function () {
    $component = Component::urlButton(['event/01']);

    expect($component)->toBeInstanceOf(Component\UrlButton::class);
});

it('can return a quick reply button component', function () {
    $component = Component::quickReplyButton(['Thanks for your message!']);

    expect($component)->toBeInstanceOf(Component\QuickReplyButton::class);
});

it('can return a flow button component', function () {
    $component = Component::flowButton('token', ['test' => 'example']);

    expect($component)->toBeInstanceOf(Component\FlowButton::class);
});
