<?php

declare(strict_types=1);

namespace NotificationChannels\WhatsApp;

use Netflie\WhatsAppCloudApi\Message\Template\Component as CloudApiComponent;
use NotificationChannels\WhatsApp\Component\Button;
use NotificationChannels\WhatsApp\Component\Component;

class WhatsAppTemplate
{
    /**
     * Template header, body and buttons can be personalized with custom variable values.
     *
     * @link https://developers.facebook.com/docs/whatsapp/cloud-api/guides/send-message-templates See how you can personalize your templates.
     */
    protected array $components;

    /**
     * The message type.
     */
    protected static string $type = 'template';

    /**
     * @param  string  $to  WhatsApp ID or phone number for the person you want to send a message to.
     * @param  string  $name  Name of the template. @link https://business.facebook.com/wa/manage/message-templates/ Dashboard to manage (create, edit and delete) templates.
     * @param  string  $language  Language code for the template. @link https://developers.facebook.com/docs/whatsapp/api/messages/message-templates#supported-languages See supported language codes.
     */
    protected function __construct(
        protected string $to = '',
        protected string $name = '',
        protected string $language = 'en_US')
    {
        $this->components = [
            'header' => [],
            'body' => [],
            'buttons' => [],
        ];
    }

    public static function create($to = '', $name = '', $language = 'en_US'): self
    {
        return new self($to, $name, $language);
    }

    public function to(string $to): self
    {
        $this->to = $to;

        return $this;
    }

    public function name(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function language(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function header(Component $component): self
    {
        $this->components['header'][] = $component->toArray();

        return $this;
    }

    public function body(Component $component): self
    {
        $this->components['body'][] = $component->toArray();

        return $this;
    }

    public function recipient(): ?string
    {
        return $this->to;
    }

    public function configuredName(): ?string
    {
        return $this->name;
    }

    public function configuredLanguage(): string
    {
        return $this->language;
    }

    public function components(): CloudApiComponent
    {
        return new CloudApiComponent(
            $this->components['header'],
            $this->components['body'],
            $this->components['buttons']
        );
    }

    public function buttons(Button $component): self
    {
        $buttons = $this->components['buttons'];
        $component->setIndex(count($buttons));
        $this->components['buttons'][] = $component->toArray();

        return $this;
    }

    public function hasRecipient(): bool
    {
        return ! empty($this->to);
    }

    public function type(): string
    {
        return self::$type;
    }
}
