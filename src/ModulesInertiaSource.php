<?php

namespace Dongrim\ModulesInertia;

use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Facades\File;
use Dongrim\ModulesInertia\Exceptions\ModuleNotExist;
use Dongrim\ModulesInertia\Exceptions\ModuleNameNotFound;
use Dongrim\ModulesInertia\Exceptions\FilePathIsIncorrect;
use Dongrim\ModulesInertia\Exceptions\FilePathNotSpecified;

class ModulesInertiaSource
{
    public function build(string $source): string
    {
        $sourceData = $this->explodeSource($source);
        $moduleName = $this->getModuleName($sourceData[0]);
        $resourcePath = config('modules.paths.source');
        $path = $this->getPath($sourceData[1]);

        return $this->getFullPath($moduleName, $resourcePath, $path);
    }

    private function getFullPath(string $moduleName, string $resourcePath, string $path): string
    {
        $fullPath = module_path($moduleName, $resourcePath . DIRECTORY_SEPARATOR . $path . '.vue');

        if (!File::exists($fullPath)) {
            throw FilePathIsIncorrect::make($fullPath);
        }

        return $moduleName . "::" . $resourcePath . DIRECTORY_SEPARATOR . $path;
    }

    private function getPath(string $string): string
    {
        if (blank($string)) {
            throw FilePathNotSpecified::make();
        }

        $path = "";
        $pathSource = $this->explodeString($string);

        foreach ($pathSource as $item) {
            $path .= Str::title($item) . DIRECTORY_SEPARATOR;
        }

        return rtrim($path, DIRECTORY_SEPARATOR);
    }

    private function explodeString(string $string): array
    {
        if (Str::contains($string, '.vue')) {
            $string = Str::before($string, '.vue');
        }

        return explode(".", $string);
    }

    private function getModuleName(string $moduleName): string
    {
        $moduleName = Str::title($moduleName);

        if (!Module::has($moduleName)) {
            throw ModuleNotExist::make($moduleName);
        }

        return $moduleName;
    }

    private function explodeSource(string $source): array
    {
        if (stripos($source, "::", 0) === false) {
            throw ModuleNameNotFound::make();
        }

        return explode("::", $source);
    }
}
