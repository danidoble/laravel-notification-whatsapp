<?php

declare(strict_types=1);

namespace NotificationChannels\WhatsApp;

use Illuminate\Notifications\Notification;
use Netflie\WhatsAppCloudApi\Response;
use Netflie\WhatsAppCloudApi\Response\ResponseException;
use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;
use NotificationChannels\WhatsApp\Exceptions\CouldNotSendNotification;

class WhatsAppChannel
{
    /**
     * @param  WhatsAppCloudApi  $whatsapp  HTTP WhatsApp Cloud API wrapper
     */
    public function __construct(private readonly WhatsAppCloudApi $whatsapp)
    {
    }

    /**
     * Send the given notification.
     *
     * @throws CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification): ?Response
    {
        // @phpstan-ignore-next-line
        $message = $notification->toWhatsApp($notifiable);

        if (! $message->hasRecipient()) {
            $to = $notifiable->routeNotificationFor('whatsapp', $notification)
                ?? $notifiable->routeNotificationFor(self::class, $notification);

            if (! $to) {
                return null;
            }

            $message->to($to);
        }

        try {
            return $this->whatsapp->sendTemplate(
                $message->recipient(),
                $message->configuredName(),
                $message->configuredLanguage(),
                $message->components()
            );
        } catch (ResponseException $e) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($e->response()->body());
        }
    }
}
