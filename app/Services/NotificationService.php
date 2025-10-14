<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\GeneralNotification;
use Filament\Notifications\Notification;

class NotificationService
{
    /**
     * Send a notification to a specific user
     */
    public static function sendToUser(
        User $user,
        string $title,
        string $message,
        string $icon = 'heroicon-o-bell',
        string $color = 'info',
        ?string $actionUrl = null,
        ?string $actionText = null
    ): void {
        $user->notify(new GeneralNotification(
            $title,
            $message,
            $icon,
            $color,
            $actionUrl,
            $actionText
        ));
    }

    /**
     * Send a notification to multiple users
     */
    public static function sendToUsers(
        iterable $users,
        string $title,
        string $message,
        string $icon = 'heroicon-o-bell',
        string $color = 'info',
        ?string $actionUrl = null,
        ?string $actionText = null
    ): int {
        $count = 0;
        foreach ($users as $user) {
            self::sendToUser($user, $title, $message, $icon, $color, $actionUrl, $actionText);
            $count++;
        }
        return $count;
    }

    /**
     * Send a notification to all users
     */
    public static function sendToAll(
        string $title,
        string $message,
        string $icon = 'heroicon-o-bell',
        string $color = 'info',
        ?string $actionUrl = null,
        ?string $actionText = null
    ): int {
        $users = User::all();
        return self::sendToUsers($users, $title, $message, $icon, $color, $actionUrl, $actionText);
    }

    /**
     * Send a success notification
     */
    public static function success(
        User $user,
        string $title,
        string $message,
        ?string $actionUrl = null,
        ?string $actionText = null
    ): void {
        self::sendToUser($user, $title, $message, 'heroicon-o-check-circle', 'success', $actionUrl, $actionText);
    }

    /**
     * Send a warning notification
     */
    public static function warning(
        User $user,
        string $title,
        string $message,
        ?string $actionUrl = null,
        ?string $actionText = null
    ): void {
        self::sendToUser($user, $title, $message, 'heroicon-o-exclamation-triangle', 'warning', $actionUrl, $actionText);
    }

    /**
     * Send an error notification
     */
    public static function error(
        User $user,
        string $title,
        string $message,
        ?string $actionUrl = null,
        ?string $actionText = null
    ): void {
        self::sendToUser($user, $title, $message, 'heroicon-o-x-circle', 'danger', $actionUrl, $actionText);
    }

    /**
     * Send an info notification
     */
    public static function info(
        User $user,
        string $title,
        string $message,
        ?string $actionUrl = null,
        ?string $actionText = null
    ): void {
        self::sendToUser($user, $title, $message, 'heroicon-o-information-circle', 'info', $actionUrl, $actionText);
    }

    /**
     * Send a Filament notification (toast)
     */
    public static function sendToast(
        string $title,
        string $message = '',
        string $color = 'info'
    ): void {
        $notification = Notification::make()
            ->title($title)
            ->body($message);

        match($color) {
            'success' => $notification->success(),
            'warning' => $notification->warning(),
            'danger', 'error' => $notification->danger(),
            default => $notification->info()
        };

        $notification->send();
    }
}
