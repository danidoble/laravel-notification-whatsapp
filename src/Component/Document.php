<?php

declare(strict_types=1);

namespace NotificationChannels\WhatsApp\Component;

use NotificationChannels\WhatsApp\Exceptions\UnsupportedMediaValue;

class Document extends Component
{
    protected const SUPPORTED_EXTENSIONS = ['pdf'];

    /**
     * @param  string  $link  Link to the document; e.g. https://URL
     *                        Only PDF documents are supported.
     *
     * @throws UnsupportedMediaValue
     */
    public function __construct(protected string $link, protected ?string $filename = null)
    {
        if (filter_var($link, FILTER_VALIDATE_URL) === false) {
            throw new UnsupportedMediaValue($link, 'document', 'Link is not a valid URL');
        }

        $extension = pathinfo($link, PATHINFO_EXTENSION);

        if (! in_array($extension, static::SUPPORTED_EXTENSIONS)) {
            throw new UnsupportedMediaValue($link, 'document', 'Only PDF documents are supported.');
        }
    }

    public function toArray(): array
    {
        $array = [
            'type' => 'document',
            'document' => [
                'link' => $this->link,
            ],
        ];
        if (! blank($this->filename)) {
            $array['document']['filename'] = $this->filename;
        }

        return $array;
    }
}
