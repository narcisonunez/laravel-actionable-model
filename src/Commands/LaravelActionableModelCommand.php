<?php

namespace Narcisonunez\LaravelActionableModel\Commands;

use Illuminate\Console\Command;

class LaravelActionableModelCommand extends Command
{
    public $signature = 'laravel-actionable-model';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
