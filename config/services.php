<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party WhatsApp Services
    |--------------------------------------------------------------------------
    |
    | Add the WhatsApp from phone number id and token here. You can get these
    | from the WhatsApp Business API dashboard.
    |
    */

    'whatsapp' => [
        'from-phone-number-id' => env('WHATSAPP_FROM_PHONE_NUMBER_ID'),
        'token' => env('WHATSAPP_TOKEN'),
    ],
];
