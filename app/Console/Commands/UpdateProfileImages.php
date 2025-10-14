<?php

namespace App\Console\Commands;

use App\Models\Profile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class UpdateProfileImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'profiles:update-images {--force : Force update even if images already exist}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all profile images with sequential URLs from escortsmassage.com';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Starting profile image update process...');

        // Get all profiles
        $query = Profile::query();
        if (!$this->option('force')) {
            $query->whereNull('image');
        }
        $profiles = $query->get();

        if ($profiles->isEmpty()) {
            $this->info('✅ No profiles found that need image updates.');
            return;
        }

        $this->info("📸 Found {$profiles->count()} profiles to update");

        // Base URL for images
        $baseUrl = 'https://escortsmassage.com/images/users/';
        $imageCounter = 1;

        // Create profiles directory if it doesn't exist
        $profilesDir = storage_path('app/public/profiles');
        if (!File::exists($profilesDir)) {
            File::makeDirectory($profilesDir, 0755, true);
            $this->info('📁 Created profiles directory');
        }

        $successCount = 0;
        $errorCount = 0;

        $this->newLine();
        $this->info('⏳ Processing profiles...');

        $progressBar = $this->output->createProgressBar($profiles->count());
        $progressBar->start();

        foreach ($profiles as $profile) {
            try {
                // Construct image URL
                $imageUrl = $baseUrl . $imageCounter . '.webp?auto=compress&cs=tinysrgb&w=600';

                // Download image with timeout
                $context = stream_context_create([
                    'http' => [
                        'timeout' => 30, // 30 second timeout
                        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
                    ]
                ]);

                $imageContents = @file_get_contents($imageUrl, false, $context);

                if ($imageContents === false) {
                    $this->newLine();
                    $this->error("❌ Failed to download image for {$profile->name} from: {$imageUrl}");
                    $errorCount++;
                    $imageCounter++;
                    $progressBar->advance();
                    continue;
                }

                // Generate unique filename
                $imageName = 'profile_' . $profile->id . '_' . $imageCounter . '.webp';
                $imagePath = $profilesDir . '/' . $imageName;

                // Save image to storage
                if (File::put($imagePath, $imageContents)) {
                    // Update profile with relative path for Filament
                    $profile->image = 'profiles/' . $imageName;
                    $profile->save();

                    $this->newLine();
                    $this->info("✅ Updated {$profile->name} with image: {$imageName}");
                    $successCount++;
                } else {
                    $this->newLine();
                    $this->error("❌ Failed to save image for {$profile->name}");
                    $errorCount++;
                }

            } catch (\Exception $e) {
                $this->newLine();
                $this->error("❌ Error processing {$profile->name}: " . $e->getMessage());
                $errorCount++;
            }

            $imageCounter++;
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        // Summary
        $this->info('🎉 Image update process completed!');
        $this->info("✅ Successfully updated: {$successCount} profiles");
        if ($errorCount > 0) {
            $this->error("❌ Failed to update: {$errorCount} profiles");
        }
        $this->info("📸 Total profiles processed: " . ($successCount + $errorCount));

        // Additional info
        $this->newLine();
        $this->info('💡 Note: Images are stored in storage/app/public/profiles/');
        $this->info('🔗 Make sure to run: php artisan storage:link (if not already done)');

        return 0;
    }
}
