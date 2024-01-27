<?php

namespace Susheelbhai\WhatsApp;

use Illuminate\Support\ServiceProvider;
use Susheelbhai\WhatsApp\Services\WhatsAppService;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\App;
use Susheelbhai\WhatsApp\Contracts\WhatsAppContract;

class WhatsAppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/whatsapp.php','whatsapp');
        $this->app->bind('whatsapp', function(){
            return new WhatsAppService(App::make("Susheelbhai\WhatsApp\Contracts\WhatsAppContract"));
        });
        $this->app->bind(\Susheelbhai\WhatsApp\Contracts\WhatsAppContract::class, \Susheelbhai\WhatsApp\Repository\SMS4power::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('WhatsApp', \Susheelbhai\WhatsApp\Services\Facades\WhatsApp::class);
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
