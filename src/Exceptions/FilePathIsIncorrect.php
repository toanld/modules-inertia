<?php

namespace Dongrim\ModulesInertia\Exceptions;

class FilePathIsIncorrect extends \Exception
{
    public static function make($path): self
    {
        return new static("Vue file from path {$path} does not exist.");
    }
}
