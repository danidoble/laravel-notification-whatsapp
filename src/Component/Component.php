<?php

declare(strict_types=1);

namespace NotificationChannels\WhatsApp\Component;

abstract class Component
{
    abstract public function toArray(): array;
}
