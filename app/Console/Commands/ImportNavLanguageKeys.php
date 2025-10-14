<?php

namespace App\Console\Commands;

use App\Models\LanguageKey;
use App\Models\LanguageString;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportNavLanguageKeys extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-nav-language-keys {--min-id=83 : Minimum language_string ID to import}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import navigation language keys from language_strings table (id >= 83 by default)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $minId = (int) $this->option('min-id');

        $this->info("Starting import of navigation language keys from language_strings with id >= {$minId}");

        // Get unique strings from language_strings where id >= minId
        $navStrings = LanguageString::where('id', '>=', $minId)
            ->select('string')
            ->distinct()
            ->pluck('string')
            ->toArray();

        $this->info("Found " . count($navStrings) . " unique navigation strings to import");

        if (empty($navStrings)) {
            $this->warn("No navigation strings found with id >= {$minId}");
            return;
        }

        // Confirm before proceeding
        if (!$this->confirm('This will truncate the language_keys table. Continue?', true)) {
            $this->info('Operation cancelled.');
            return;
        }

        DB::beginTransaction();

        try {
            // Delete all existing language keys instead of truncate
            $this->info('Deleting existing language keys...');
            LanguageKey::query()->delete();

            // Create language keys for each unique string
            $createdKeys = 0;
            foreach ($navStrings as $stringKey) {
                LanguageKey::create([
                    'key' => $stringKey,
                    'type' => 'nav', // Mark as navigation type
                    'is_active' => true,
                ]);
                $createdKeys++;
            }

            $this->info("Created {$createdKeys} language keys");

            // Update language_strings to link to the new keys
            $updatedStrings = 0;
            foreach ($navStrings as $stringKey) {
                $languageKey = LanguageKey::where('key', $stringKey)->first();

                if ($languageKey) {
                    LanguageString::where('id', '>=', $minId)
                        ->where('string', $stringKey)
                        ->update(['language_key_id' => $languageKey->id]);

                    $updatedStrings += LanguageString::where('id', '>=', $minId)
                        ->where('string', $stringKey)
                        ->count();
                }
            }

            DB::commit();

            $this->info("Successfully updated {$updatedStrings} language strings");
            $this->info('Import completed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Import failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
