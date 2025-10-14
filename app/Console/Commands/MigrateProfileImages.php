<?php

namespace App\Console\Commands;

use App\Models\Profile;
use Illuminate\Console\Command;

class MigrateProfileImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'profiles:migrate-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate existing single images to the new multiple images structure';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting profile images migration...');
        
        $profiles = Profile::whereNotNull('image')->get();
        $progressBar = $this->output->createProgressBar($profiles->count());
        $progressBar->start();
        
        $migrated = 0;
        $skipped = 0;
        
        foreach ($profiles as $profile) {
            try {
                // Skip if already migrated
                if ($profile->images && is_array($profile->images) && count($profile->images) > 0) {
                    $skipped++;
                    $progressBar->advance();
                    continue;
                }
                
                // Migrate single image to images array
                if ($profile->image) {
                    $profile->images = [$profile->image];
                    
                    // Set as main image if not already set
                    if (!$profile->main_image) {
                        $profile->main_image = $profile->image;
                    }
                    
                    $profile->save();
                    $migrated++;
                }
                
            } catch (\Exception $e) {
                $this->error("Failed to migrate profile {$profile->id}: " . $e->getMessage());
            }
            
            $progressBar->advance();
        }
        
        $progressBar->finish();
        $this->newLine();
        
        $this->info("Migration completed!");
        $this->info("Migrated: {$migrated} profiles");
        $this->info("Skipped: {$skipped} profiles (already migrated)");
        
        return Command::SUCCESS;
    }
}