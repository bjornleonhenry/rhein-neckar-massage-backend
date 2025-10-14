<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrateSqliteToMysql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:sqlite-to-mysql {--force : Force migration without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate all data from SQLite database to MySQL database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $force = $this->option('force');
        
        if (!$force) {
            if (!$this->confirm('This will migrate all data from SQLite to MySQL. Continue?')) {
                $this->info('Migration cancelled.');
                return;
            }
        }

        $this->info('Starting SQLite to MySQL data migration...');
        
        try {
            // Configure SQLite connection with absolute path
            $sqlitePath = database_path('database.sqlite');
            config(['database.connections.sqlite.database' => $sqlitePath]);
            
            // Test connections
            $this->testConnections();
            
            // Get existing data counts
            $this->showDataCounts();
            
            // Disable foreign key checks temporarily
            DB::connection('mysql')->statement('SET FOREIGN_KEY_CHECKS=0');
            
            // Migrate tables
            $this->migrateTables();
            
            // Re-enable foreign key checks
            DB::connection('mysql')->statement('SET FOREIGN_KEY_CHECKS=1');
            
            // Verify migration
            $this->verifyMigration();
            
            $this->info('Migration completed successfully!');
            
        } catch (\Exception $e) {
            $this->error('Migration failed: ' . $e->getMessage());
            
            // Re-enable foreign key checks in case of error
            DB::connection('mysql')->statement('SET FOREIGN_KEY_CHECKS=1');
            
            return 1;
        }
    }

    private function testConnections()
    {
        $this->info('Testing database connections...');
        
        try {
            // Test SQLite connection with absolute path
            $sqlitePath = database_path('database.sqlite');
            config(['database.connections.sqlite.database' => $sqlitePath]);
            
            $sqliteCount = DB::connection('sqlite')->table('users')->count();
            $this->line("SQLite connection: OK (users table has $sqliteCount records)");
            
            // Test MySQL connection
            $mysqlCount = DB::connection('mysql')->table('users')->count();
            $this->line("MySQL connection: OK (users table has $mysqlCount records)");
            
        } catch (\Exception $e) {
            throw new \Exception("Database connection test failed: " . $e->getMessage());
        }
    }

    private function showDataCounts()
    {
        $this->info('Current data counts in SQLite:');
        
        $tables = [
            'migrations', 'users', 'password_reset_tokens', 'sessions', 'cache', 'cache_locks',
            'jobs', 'job_batches', 'failed_jobs', 'angebots', 'ambients', 'gaestebuchs',
            'telescope_entries', 'telescope_entries_tags', 'telescope_monitoring',
            'api_docs', 'notifications', 'settings', 'filament_webhook_servers',
            'filament_webhook_server_histories', 'terminal_console_settings',
            'deepseek_conversations', 'language_strings', 'messages', 'job_applications',
            'bookings', 'profile_infos', 'mieterinnen', 'profiles', 'profile_options', 'db_config'
        ];
        
        foreach ($tables as $table) {
            try {
                if (Schema::connection('sqlite')->hasTable($table)) {
                    $count = DB::connection('sqlite')->table($table)->count();
                    $this->line("$table: $count records");
                }
            } catch (\Exception $e) {
                $this->line("$table: Error - " . $e->getMessage());
            }
        }
    }

    private function migrateTables()
    {
        $this->info('Starting table migration...');
        
        $tables = [
            'migrations', 'users', 'password_reset_tokens', 'sessions', 'cache', 'cache_locks',
            'jobs', 'job_batches', 'failed_jobs', 'angebots', 'ambients', 'gaestebuchs',
            'telescope_entries', 'telescope_entries_tags', 'telescope_monitoring',
            'api_docs', 'notifications', 'settings', 'filament_webhook_servers',
            'filament_webhook_server_histories', 'terminal_console_settings',
            'deepseek_conversations', 'language_strings', 'messages', 'job_applications',
            'bookings', 'profile_infos', 'mieterinnen', 'profiles', 'profile_options', 'db_config'
        ];
        
        $progressBar = $this->output->createProgressBar(count($tables));
        $progressBar->start();
        
        foreach ($tables as $table) {
            try {
                if (Schema::connection('sqlite')->hasTable($table)) {
                    $this->migrateTable($table);
                }
                $progressBar->advance();
            } catch (\Exception $e) {
                $progressBar->finish();
                throw new \Exception("Error migrating table '$table': " . $e->getMessage());
            }
        }
        
        $progressBar->finish();
        $this->newLine();
    }

    private function migrateTable($tableName)
    {
        try {
            // Check if table exists in both databases
            $sqliteExists = Schema::connection('sqlite')->hasTable($tableName);
            $mysqlExists = Schema::connection('mysql')->hasTable($tableName);
            
            if (!$sqliteExists) {
                $this->line("Table '$tableName' does not exist in SQLite, skipping...");
                return;
            }
            
            if (!$mysqlExists) {
                $this->line("Table '$tableName' does not exist in MySQL, skipping...");
                return;
            }
            
            // Clear existing data in MySQL table
            DB::connection('mysql')->table($tableName)->truncate();
            
            // Get column names from both databases
            $mysqlColumns = $this->getTableColumns($tableName, 'mysql');
            $sqliteColumns = $this->getTableColumns($tableName, 'sqlite');
            
            // Find common columns
            $commonColumns = array_intersect($mysqlColumns, $sqliteColumns);
            
            if (empty($commonColumns)) {
                $this->line("No common columns found for table '$tableName', skipping...");
                return;
            }
            
            // Get all data from SQLite (only common columns)
            $sqliteData = DB::connection('sqlite')->table($tableName)->select($commonColumns)->get();
            
            if ($sqliteData->isEmpty()) {
                return;
            }
            
            // Process data in chunks
            $chunkSize = 1000;
            $chunks = $sqliteData->chunk($chunkSize);
            
            foreach ($chunks as $chunk) {
                // Convert collection to array
                $data = $chunk->toArray();
                
                // Ensure we have associative arrays with only common columns
                $preparedData = [];
                foreach ($data as $record) {
                    if (is_object($record)) {
                        $recordArray = (array) $record;
                    } else {
                        $recordArray = $record;
                    }
                    
                    // Filter to only include common columns
                    $filteredRecord = [];
                    foreach ($commonColumns as $column) {
                        if (array_key_exists($column, $recordArray)) {
                            $filteredRecord[$column] = $recordArray[$column];
                        }
                    }
                    $preparedData[] = $filteredRecord;
                }
                
                // Insert into MySQL
                DB::connection('mysql')->table($tableName)->insert($preparedData);
            }
            
        } catch (\Exception $e) {
            throw new \Exception("Failed to migrate table '$tableName': " . $e->getMessage());
        }
    }

    private function getTableColumns($tableName, $connection)
    {
        try {
            $columns = DB::connection($connection)->getSchemaBuilder()->getColumnListing($tableName);
            return $columns;
        } catch (\Exception $e) {
            return [];
        }
    }

    private function prepareDataForMysql($data)
    {
        $preparedData = [];
        
        foreach ($data as $record) {
            $preparedRecord = [];
            foreach ($record as $key => $value) {
                // Handle boolean values
                if (is_numeric($value) && in_array($key, ['is_active', 'is_default', 'is_verified'])) {
                    $preparedRecord[$key] = (bool) $value;
                } else {
                    $preparedRecord[$key] = $value;
                }
            }
            $preparedData[] = $preparedRecord;
        }
        
        return $preparedData;
    }

    private function isJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    private function verifyMigration()
    {
        $this->info('Verifying migration...');
        
        $tables = [
            'migrations', 'users', 'password_reset_tokens', 'sessions', 'cache', 'cache_locks',
            'jobs', 'job_batches', 'failed_jobs', 'angebots', 'ambients', 'gaestebuchs',
            'telescope_entries', 'telescope_entries_tags', 'telescope_monitoring',
            'api_docs', 'notifications', 'settings', 'filament_webhook_servers',
            'filament_webhook_server_histories', 'terminal_console_settings',
            'deepseek_conversations', 'language_strings', 'messages', 'job_applications',
            'bookings', 'profile_infos', 'mieterinnen', 'profiles', 'profile_options', 'db_config'
        ];
        
        $mismatches = [];
        
        foreach ($tables as $table) {
            try {
                if (Schema::connection('sqlite')->hasTable($table) && 
                    Schema::connection('mysql')->hasTable($table)) {
                    
                    $sqliteCount = DB::connection('sqlite')->table($table)->count();
                    $mysqlCount = DB::connection('mysql')->table($table)->count();
                    
                    if ($sqliteCount === $mysqlCount) {
                        $this->line("✓ $table: $mysqlCount records");
                    } else {
                        $this->line("✗ $table: SQLite=$sqliteCount, MySQL=$mysqlCount");
                        $mismatches[] = $table;
                    }
                }
            } catch (\Exception $e) {
                $this->line("✗ $table: Error - " . $e->getMessage());
                $mismatches[] = $table;
            }
        }
        
        if (!empty($mismatches)) {
            $this->warn('Found ' . count($mismatches) . ' tables with mismatched record counts:');
            foreach ($mismatches as $table) {
                $this->line("  - $table");
            }
        } else {
            $this->info('✓ All tables migrated successfully with matching record counts!');
        }
    }
}
