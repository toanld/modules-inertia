<?php

namespace Dongrim\ModulesInertia\Exceptions;

class FilePathNotSpecified extends \Exception
{
    public static function make(): self
    {
        return new static("Display file path not specified.");
    }
}
