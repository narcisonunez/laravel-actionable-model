<?php


namespace Narcisonunez\LaravelActionableModel\Tests\Facades;

use Narcisonunez\LaravelActionableModel\ActionableActionTypes as ActionableActionTypesImplementation;
use Narcisonunez\LaravelActionableModel\Facades\ActionableActionTypes;
use Narcisonunez\LaravelActionableModel\Tests\TestCase;

class ActionableActionTypesTest extends TestCase
{
    /** @test */
    public function check_registered_actions_are_store_correctly()
    {
        $actions = ['likes', 'kudos'];
        ActionableActionTypes::register($actions);

        $containerActions = $this->app->get(ActionableActionTypesImplementation::class)->actions;

        $this->assertArrayHasKey('likes', $containerActions);
        $this->assertArrayHasKey('kudos', $containerActions);
    }
}
