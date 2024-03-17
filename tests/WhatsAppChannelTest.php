<?php

use Illuminate\Notifications\Notifiable;
use Netflie\WhatsAppCloudApi\Http\ClientHandler;
use Netflie\WhatsAppCloudApi\Http\RawResponse;
use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;
use NotificationChannels\WhatsApp\Exceptions\CouldNotSendNotification;
use NotificationChannels\WhatsApp\Test\Support\DummyNotifiable;
use NotificationChannels\WhatsApp\Test\Support\DummyNotification;
use NotificationChannels\WhatsApp\Test\Support\DummyNotificationWithoutRecipient;
use NotificationChannels\WhatsApp\WhatsAppChannel;

beforeEach(function () {
    $httpClient = \Mockery::mock(ClientHandler::class);

    $whatsapp = new WhatsAppCloudApi([
        'from_phone_number_id' => '34676202545',
        'access_token' => 'super-secret',
        'client_handler' => $httpClient,
    ]);
    $channel = new WhatsAppChannel($whatsapp);

    // @phpstan-ignore-next-line
    $this->whatsapp = $whatsapp;
    // @phpstan-ignore-next-line
    $this->channel = $channel;
    // @phpstan-ignore-next-line
    $this->httpClient = $httpClient;
});

it('can send a notification', function () {
    $notifiable = Mockery::mock(Notifiable::class);
    $notification = new DummyNotification();

    $body = [
        'messaging_product' => 'whatsapp',
        'recipient_type' => 'individual',
        'to' => $notification->toWhatsApp($notifiable)->recipient(),
        'type' => 'template',
        'template' => [
            'name' => $notification->toWhatsApp($notifiable)->configuredName(),
            'language' => ['code' => $notification->toWhatsApp($notifiable)->configuredLanguage()],
            'components' => [],
        ],
    ];
    $headers = [
        'Authorization' => 'Bearer super-secret',
        'Content-Type' => 'application/json',
    ];
    $expectedResponse = new RawResponse($headers, json_encode($body), 200);

    // @phpstan-ignore-next-line
    $response = sendMockNotification($this, $notifiable, $notification, $expectedResponse);

    expect($response->body())->toEqual(json_encode($body))
        ->and($response->httpStatusCode())->toEqual(200)
        ->and($notification->toWhatsApp($notifiable)->recipient())->not->toBeEmpty()
        ->and($notification->toWhatsApp($notifiable)->configuredName())->not->toBeEmpty()
        ->and($notification->toWhatsApp($notifiable)->configuredLanguage())->not->toBeEmpty();
});

it('can send a notification if notifiable provide a recipient from route', function () {
    $notifiable = new DummyNotifiable();
    $notification = new DummyNotificationWithoutRecipient();

    $body = [
        'messaging_product' => 'whatsapp',
        'recipient_type' => 'individual',
        'to' => $notifiable->routeNotificationForWhatsApp(),
        'type' => 'template',
        'template' => [
            'name' => $notification->toWhatsApp($notifiable)->configuredName(),
            'language' => ['code' => $notification->toWhatsApp($notifiable)->configuredLanguage()],
            'components' => [],
        ],
    ];
    $headers = [
        'Authorization' => 'Bearer super-secret',
        'Content-Type' => 'application/json',
    ];
    $expectedResponse = new RawResponse($headers, json_encode($body), 200);

    // @phpstan-ignore-next-line
    $response = sendMockNotification($this, $notifiable, $notification, $expectedResponse);

    expect($response->body())->toEqual(json_encode($body))
        ->and($response->httpStatusCode())->toEqual(200)
        ->and($body['to'])->not->toBeEmpty()
        ->and($notification->toWhatsApp($notifiable)->configuredName())->not->toBeEmpty()
        ->and($notification->toWhatsApp($notifiable)->configuredLanguage())->not->toBeEmpty();
});

it('does not send a notification if the notifiable does not provide a recipient', function () {
    $notifiable = Mockery::mock(Notifiable::class);
    $notification = new DummyNotificationWithoutRecipient();

    $httpClient = \Mockery::mock(ClientHandler::class);
    $httpClient->shouldNotHaveReceived('send');

    // @phpstan-ignore-next-line
    $response = $this->channel->send($notifiable, $notification);

    expect($response)->toBeNull();
});

test('send notification failed', function () {
    $notifiable = Mockery::mock(Notifiable::class);
    $notification = new DummyNotification();
    $expectedResponse = new RawResponse([], json_encode(['error' => true]), 500);

    // @phpstan-ignore-next-line
    $this->expectException(CouldNotSendNotification::class);
    // @phpstan-ignore-next-line
    $response = sendMockNotification($this, $notifiable, $notification, $expectedResponse);

    expect($response)->toBeNull();
});
