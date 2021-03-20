<?php

namespace Narcisonunez\LaravelActionableModel;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Narcisonunez\LaravelActionableModel\Commands\LaravelActionableModelCommand;

class LaravelActionableModelServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-actionable-model')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_actionable_model_table')
            ->hasCommand(LaravelActionableModelCommand::class);
    }
}
