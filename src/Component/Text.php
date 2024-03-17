<?php

declare(strict_types=1);

namespace NotificationChannels\WhatsApp\Component;

class Text extends Component
{
    public function __construct(protected string $text)
    {
    }

    public function toArray(): array
    {
        return [
            'type' => 'text',
            'text' => $this->text,
        ];
    }
}
