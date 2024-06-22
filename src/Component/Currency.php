<?php

declare(strict_types=1);

namespace NotificationChannels\WhatsApp\Component;

class Currency extends Component
{
    /**
     * @param  string  $code  Currency code as defined in ISO 4217.
     */
    public function __construct(protected float $amount, protected string $code = 'EUR') {}

    public function toArray(): array
    {
        return [
            'type' => 'currency',
            'currency' => [
                'code' => $this->code,
                'amount_1000' => (int) ($this->amount * 1000),
            ],
        ];
    }
}
