<?php

namespace Narcisonunez\LaravelActionableModel\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Narcisonunez\LaravelActionableModel\LaravelActionableModelServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Narcisonunez\\LaravelActionableModel\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelActionableModelServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        include_once __DIR__.'/../database/migrations/create_actionable_records_table.php.stub';
        (new \CreateActionableRecordsTable())->up();
    }
}
