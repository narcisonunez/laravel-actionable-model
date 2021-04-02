<?php


namespace Narcisonunez\LaravelActionableModel\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeActionTypeCommand extends GeneratorCommand
{
    public $signature = 'actionable:type {name : Name of the Action Type} {--force : Replace if the class already exists}';

    public $description = 'Create a new Action Type Class';

    public $type = 'Action Type';

    /**
     * @return bool|void|null
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        parent::handle();
    }

    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/action_type.stub');
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param string $stub
     * @return string
     */
    protected function resolveStubPath($stub)
    {
        return __DIR__ . $stub;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return "App\\ActionTypes";
    }
}
