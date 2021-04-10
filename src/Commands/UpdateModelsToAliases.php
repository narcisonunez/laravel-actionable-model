<?php


namespace Narcisonunez\LaravelActionableModel\Commands;

use Illuminate\Console\Command;
use Narcisonunez\LaravelActionableModel\Facades\ActionableModelAliases;
use Narcisonunez\LaravelActionableModel\Models\ActionableRecord;

class UpdateModelsToAliases extends Command
{
    public $signature = 'actionable:update-aliases {--from= : Existing model path} {--to= : Model alias}';

    public $description = 'Update current database records to use the alias instead of the model path';

    /**
     * @return bool|void|null
     */
    public function handle()
    {
        $aliases = ActionableModelAliases::all();

        if ($this->hasOption('from') && $this->hasOption('to')) {
            $aliases = [];
            $aliases[$this->option('from')] = $this->option('to');
        }

        foreach ($aliases as $model => $alias) {
            ActionableRecord::where('performed_by_type', $model)->update([
                'performed_by_type' => $alias,
            ]);

            ActionableRecord::where('actionable_type', $model)->update([
                'actionable_type' => $alias,
            ]);
        }

        $this->info('Records updated successfully.');
    }
}
