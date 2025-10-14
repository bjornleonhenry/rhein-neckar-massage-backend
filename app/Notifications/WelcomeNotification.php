<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Welcome to Your Admin Panel!')
            ->greeting('Hello!')
            ->line('Welcome to your Filament admin panel. You can now manage your application with ease.')
            ->action('Go to Admin Panel', url('/admin'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Welcome to Filament!',
            'message' => 'Your admin panel is ready to use. Start exploring the features.',
            'action_url' => '/admin',
            'action_text' => 'Go to Admin',
            'icon' => 'heroicon-o-sparkles',
            'color' => 'success',
        ];
    }
}
