<?php

namespace Dongrim\ModulesInertia\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class PublishStubs extends Command
{
    protected $signature = 'module:publish-stubs';

    protected $description = 'Publish a module\'s inertia stubs.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $pathToStubs = __DIR__ . '/../../../stubs';

        File::copyDirectory($pathToStubs, base_path('stubs/dongrim'));

        $this->info('Stubs is successfully published.');
    }
}
