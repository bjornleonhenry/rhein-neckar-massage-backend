<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendTestNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:test {user?} {--type= : Type of notification (welcome, success, warning, error)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send test notifications to users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user');
        $type = $this->option('type') ?: 'success';

        if ($userId) {
            $user = \App\Models\User::find($userId);
            if (!$user) {
                $this->error("User with ID {$userId} not found.");
                return;
            }
            $users = [$user];
        } else {
            $users = \App\Models\User::all();
        }

        if ($users->isEmpty()) {
            $this->error('No users found.');
            return;
        }

        $notifications = [
            'welcome' => [
                'title' => 'Welcome to Filament!',
                'message' => 'Your admin panel is ready to use.',
                'icon' => 'heroicon-o-sparkles',
                'color' => 'success'
            ],
            'success' => [
                'title' => 'Operation Successful!',
                'message' => 'Your recent action was completed successfully.',
                'icon' => 'heroicon-o-check-circle',
                'color' => 'success'
            ],
            'warning' => [
                'title' => 'Warning',
                'message' => 'Please review your recent changes.',
                'icon' => 'heroicon-o-exclamation-triangle',
                'color' => 'warning'
            ],
            'error' => [
                'title' => 'Error Occurred',
                'message' => 'Something went wrong. Please try again.',
                'icon' => 'heroicon-o-x-circle',
                'color' => 'danger'
            ],
            'info' => [
                'title' => 'Information',
                'message' => 'Here is some important information for you.',
                'icon' => 'heroicon-o-information-circle',
                'color' => 'info'
            ]
        ];

        $notification = $notifications[$type] ?? $notifications['success'];

        foreach ($users as $user) {
            $user->notify(new \App\Notifications\GeneralNotification(
                $notification['title'],
                $notification['message'],
                $notification['icon'],
                $notification['color']
            ));

            $this->info("Notification sent to {$user->name} ({$user->email})");
        }

        $this->info("Sent {$type} notifications to " . $users->count() . " user(s)");
    }
}
