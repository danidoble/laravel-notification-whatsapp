<?php

declare(strict_types=1);

namespace NotificationChannels\WhatsApp\Exceptions;

final class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError($responseBody): CouldNotSendNotification
    {
        return new self($responseBody);
    }
}
