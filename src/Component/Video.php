<?php

declare(strict_types=1);

namespace NotificationChannels\WhatsApp\Component;

class Video extends Component
{
    /**
     * @param  string  $link  Link to the video; e.g. https://URL.
     */
    public function __construct(protected string $link)
    {
        $this->link = $link;
    }

    public function toArray(): array
    {
        return [
            'type' => 'video',
            'video' => [
                'link' => $this->link,
            ],
        ];
    }
}
