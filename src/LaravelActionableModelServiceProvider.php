<?php

namespace Narcisonunez\LaravelActionableModel;

use Narcisonunez\LaravelActionableModel\Commands\LaravelActionableModelCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
            ->hasMigration('create_actionable_records_table');

        $this->app->singleton(ActionableActionTypes::class, function () {
            return new ActionableActionTypes();
        });
    }
}
