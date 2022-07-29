<?php

namespace Dongrim\ModulesInertia;

use Inertia\Inertia;
use Illuminate\Support\ServiceProvider;
use Dongrim\ModulesInertia\Console\Commands\PublishStubs;

class ModulesInertiaServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->registerPublishing();
        }
        $this->bootingResource();
    }

    protected function registerPublishing(): void
    {
        $this->publishes([
            __DIR__ . "/../config/config.php" => config_path("modules.php")
        ], "config");
    }

    protected function bootingResource(): void
    {
        Inertia::macro('module', function ($view, $args = []) {
            return Inertia::render((new ModulesInertiaSource())->build($view), $args);
        });
    }

    public function register(): void
    {
        $this->commands([
            PublishStubs::class
        ]);

        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'modules');
    }
}
