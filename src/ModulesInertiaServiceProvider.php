<?php

namespace Dongrim\ModulesInertia;

use Inertia\Inertia;

use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

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

            if (stripos($view, "::", 0) === false) {
                throw new \Exception('The path to the file must contain Paamayim Nekudotaim');
            }

            $data = explode("::", $view);
            $moduleName = Str::title($data[0]);

            if (!Module::has($moduleName)) {
                throw new \Exception('Module ' . $data[0] . ' does not exist.');
            }

            if (blank($data[1])) {
                throw new \Exception('Display file path not specified.');
            }

            if (Str::contains($data[1], '.vue')) {
                $data[1] = Str::before($data[1], '.vue');
            }

            $source = explode(".", $data[1]);

            $path = '';
            foreach ($source as $item) {
                $path .= Str::title($item) . DIRECTORY_SEPARATOR;
            }
            $path = rtrim($path, DIRECTORY_SEPARATOR);

            $resourcePath = config('modules.paths.source');

            $fullPath = module_path($moduleName, $resourcePath . DIRECTORY_SEPARATOR . $path . '.vue');


            if (!File::exists($fullPath)) {
                throw new \Exception('Vue file from path ' . $fullPath . ' does not exist.');
            }

            $sourcePath = $moduleName . "::" . $resourcePath . DIRECTORY_SEPARATOR . $path;

            return Inertia::render($sourcePath, $args);
        });
    }

    public function register(): void
    {
    }
}
