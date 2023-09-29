<?php

namespace Susheelbhai\WhatsApp;

use Illuminate\Support\ServiceProvider;
use Susheelbhai\WhatsApp\Services\WhatsAppService;

class WhatsAppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/whatsapp.php','whatsapp');
        $this->app->bind('whatsapp', function(){
            return new WhatsAppService();
        });
    }

    
    public function boot(): void
    {
        $this->registerPublishable();
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Susheelbhai\WhatsApp\Commands\update_env::class,
            ]);
        }
    }

    public function registerPublishable()
    {
        $this->publishes([
            __dir__ . "/../config" => config_path('/'),
        ], 'whatsapp');
    }
}
