<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use App\Services\NotificationService;
use App\Filament\Widgets\CalendarWidget;

class Dashboard extends BaseDashboard
{
   protected static ?string $title = 'Dashboard';

    protected static ?int $navigationSort = 1;

    public function getWidgets(): array
    {
        return [
            CalendarWidget::class,
        ];
    }

    public function getColumns(): int | array
    {
        return 1;
    }

    protected function getHeaderActions(): array
    {
        return [
            // Notification actions hidden as requested
            // Action::make('send_test_notification')
            //     ->label('Send Test Notification')
            //     ->icon('heroicon-o-bell')
            //     ->color('success')
            //     ->action(function () {
            //         $user = auth()->user();

            //         NotificationService::sendToUser(
            //             $user,
            //             'Test Notification',
            //             'This is a test notification from your dashboard!',
            //             'heroicon-o-sparkles',
            //             'success',
            //             '/admin',
            //             'Go to Dashboard'
            //         );

            //         NotificationService::sendToast(
            //             'Test notification sent!',
            //             'Check your notifications in the top-right corner.',
            //             'success'
            //         );
            //     }),

            // Action::make('send_bulk_notification')
            //     ->label('Send to All Users')
            //     ->icon('heroicon-o-bell-alert')
            //     ->color('warning')
            //     ->requiresConfirmation()
            //     ->modalHeading('Send notification to all users?')
            //     ->modalDescription('This will send a notification to all registered users.')
            //     ->modalSubmitActionLabel('Send Notification')
            //     ->action(function () {
            //         $count = NotificationService::sendToAll(
            //             'Admin Announcement',
            //             'This is a broadcast message from the admin panel.',
            //             'heroicon-o-megaphone',
            //             'info'
            //         );

            //         NotificationService::sendToast(
            //             'Bulk notification sent!',
            //             "Sent notifications to {$count} user(s)",
            //             'success'
            //         );
            //     }),

            // ActionGroup::make([
            //     Action::make('view_notifications')
            //         ->label('View All Notifications')
            //         ->icon('heroicon-o-bell')
            //         ->badge(function () {
            //             return Auth::user()?->unreadNotifications()->count() ?? 0;
            //         })
            //         ->badgeColor('danger')
            //         ->url('/admin/notifications'),
            // ])
            // ->label('')
            // ->icon('heroicon-o-bell')
            // ->badge(function () {
            //     return Auth::user()?->unreadNotifications()->count() ?? 0;
            // })
            // ->badgeColor('danger')
            // ->visible(fn () => Auth::check()),
        ];
    }

}
