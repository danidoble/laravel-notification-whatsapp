<?php

declare(strict_types=1);

namespace NotificationChannels\WhatsApp\Providers;

use Illuminate\Support\ServiceProvider;
use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;

final class WhatsAppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/services.php', 'services');

        $config = [
            'from_phone_number_id' => $this->app->make('config')->get('services.whatsapp.from-phone-number-id'),
            'access_token' => $this->app->make('config')->get('services.whatsapp.token'),
            'graph_version' => $this->app->make('config')->get('services.whatsapp.graph_version', WhatsAppCloudApi::DEFAULT_GRAPH_VERSION),
            'timeout' => $this->app->make('config')->get('services.whatsapp.timeout'),
        ];

        $this->app->bind(WhatsAppCloudApi::class, static fn () => new WhatsAppCloudApi($config));
    }
}
