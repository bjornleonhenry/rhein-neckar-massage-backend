<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\BulkAction;
use App\Services\NotificationService;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('two_factor_confirmed_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('send_notification')
                        ->label('Send Notification')
                        ->icon('heroicon-o-bell')
                        ->color('success')
                        ->form([
                            \Filament\Forms\Components\TextInput::make('title')
                                ->label('Notification Title')
                                ->required()
                                ->default('Hello from Admin!'),
                            \Filament\Forms\Components\Textarea::make('message')
                                ->label('Notification Message')
                                ->required()
                                ->default('This is a test notification from your admin panel.'),
                            \Filament\Forms\Components\Select::make('type')
                                ->label('Notification Type')
                                ->options([
                                    'success' => 'Success',
                                    'warning' => 'Warning',
                                    'error' => 'Error',
                                    'info' => 'Info',
                                ])
                                ->default('success')
                                ->required(),
                        ])
                        ->action(function (array $data, $records) {
                            $count = 0;
                            foreach ($records as $user) {
                                NotificationService::sendToUser(
                                    $user,
                                    $data['title'],
                                    $data['message'],
                                    match($data['type']) {
                                        'success' => 'heroicon-o-check-circle',
                                        'warning' => 'heroicon-o-exclamation-triangle',
                                        'error' => 'heroicon-o-x-circle',
                                        'info' => 'heroicon-o-information-circle',
                                        default => 'heroicon-o-bell'
                                    },
                                    $data['type']
                                );
                                $count++;
                            }

                            NotificationService::sendToast(
                                'Notifications Sent!',
                                "Sent notifications to {$count} user(s)",
                                'success'
                            );
                        })
                        ->deselectRecordsAfterCompletion(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
