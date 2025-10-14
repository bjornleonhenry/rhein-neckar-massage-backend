<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ExportDataToSeeders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:export-to-seeders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export current database data to seeder files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Exporting current database data to seeders...');

        $tables = [
            'mieterinnen' => 'MieterinnenSeeder',
            'ambients' => 'AmbientSeeder', 
            'gaestebuchs' => 'GaestebuchSeeder',
            'profiles' => 'ProfilesSeeder',
            'profile_options' => 'ProfileOptionsSeeder',
        ];

        foreach ($tables as $table => $seederClass) {
            $this->exportTableToSeeder($table, $seederClass);
        }

        $this->info('Data export completed successfully!');
        return Command::SUCCESS;
    }

    private function exportTableToSeeder($table, $seederClass)
    {
        $data = DB::table($table)->get();
        
        if ($data->isEmpty()) {
            $this->warn("Table '$table' is empty, skipping...");
            return;
        }

        $modelName = ucfirst(str_replace('s', '', $table)); // Simple singularization
        if ($table === 'mieterinnen') $modelName = 'Mieterin';
        if ($table === 'ambients') $modelName = 'Ambient';
        if ($table === 'gaestebuchs') $modelName = 'Gaestebuch';
        if ($table === 'profiles') $modelName = 'Profile';
        if ($table === 'profile_options') $modelName = 'ProfileOption';

        $seederContent = "<?php\n\nnamespace Database\\Seeders;\n\nuse Illuminate\\Database\\Seeder;\nuse App\\Models\\{$modelName};\n\nclass {$seederClass} extends Seeder\n{\n    public function run(): void\n    {\n        // Get current {$table} from database and insert them\n        \$current" . ucfirst($table) . " = \\DB::table('{$table}')->get();\n        \n        foreach (\$current" . ucfirst($table) . " as \$item) {\n            {$modelName}::updateOrCreate(\n                ['id' => \$item->id],\n                (array) \$item\n            );\n        }\n    }\n}\n";

        $seederPath = database_path("seeders/{$seederClass}.php");
        File::put($seederPath, $seederContent);
        
        $this->info("Exported {$data->count()} records from '$table' to $seederClass");
    }
}
