<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\Action;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Notifications extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-bell';

    protected string $view = 'filament.pages.notifications';

    protected static ?string $navigationLabel = 'Web Notifications';

    protected static string | \UnitEnum | null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = +0;

    public function table(Table $table): Table
    {
        // Convert the MorphMany relation into an Eloquent Builder instance
        $notificationsQuery = Auth::user()
            ->notifications()
            ->getQuery()
            ->latest();

        return $table
            ->query($notificationsQuery)
            ->columns([
                IconColumn::make('read_at')
                    ->label('')
                    ->icon(fn ($record) => $record->read_at ? 'heroicon-o-check-circle' : 'heroicon-o-bell')
                    ->color(fn ($record) => $record->read_at ? 'success' : 'warning')
                    ->size('md'),

                TextColumn::make('data.title')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('data.message')
                    ->label('Message')
                    ->limit(50)
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('read_at')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => $state ? 'Read' : 'Unread')
                    ->color(fn ($state) => $state ? 'success' : 'warning')
                    ->badge(),
            ])
            ->actions([
                Action::make('mark_as_read')
                    ->label('Mark as Read')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn ($record) => !$record->read_at)
                    ->action(function ($record) {
                        $record->markAsRead();
                        $this->dispatch('refresh');
                    }),

                Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->url(fn ($record) => $record->data['url'] ?? null)
                    ->openUrlInNewTab()
                    ->visible(fn ($record) => isset($record->data['url'])),
            ])
            ->bulkActions([
                Action::make('mark_selected_as_read')
                    ->label('Mark Selected as Read')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->accessSelectedRecords()
                    ->action(function ($records) {
                        $records->each->markAsRead();
                        $this->dispatch('refresh');
                    })
                    ->deselectRecordsAfterCompletion(),
            ])
            ->emptyStateHeading('No notifications yet')
            ->emptyStateDescription('You will see your notifications here when they arrive.')
            ->emptyStateIcon('heroicon-o-bell-slash');
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        $this->dispatch('refresh');
    }
}
