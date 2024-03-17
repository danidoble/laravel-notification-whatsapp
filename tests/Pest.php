<?php

use Illuminate\Notifications\Notification;
use Netflie\WhatsAppCloudApi\Http\RawResponse;

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function sendMockNotification($context, $notifiable, Notification $notification, RawResponse $expectedResponse)
{
    $context->httpClient
        ->shouldReceive('postJsonData')
        ->once()
        ->andReturns($expectedResponse);

    return $context->channel->send($notifiable, $notification);
}
