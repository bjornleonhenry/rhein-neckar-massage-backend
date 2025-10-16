<?php

namespace App\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Filament\Forms;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Textarea;
use Saade\FilamentFullCalendar\Actions;
use App\Models\CalendarEvent;
use Illuminate\Database\Eloquent\Model;

class CalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = CalendarEvent::class;

    protected static ?int $sort = 1;

    protected static ?string $title = "calendar";

    protected static string $viewIdentifier = 'calendar-widget';

    protected int | string | array $columnSpan = 'full';

    protected function headerActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mountUsing(function ($form, array $arguments) {
                    $form->fill([
                        'start' => $arguments['start'] ?? null,
                        'end' => $arguments['end'] ?? null,
                        'all_day' => $arguments['allDay'] ?? false,
                    ]);
                })
                ->mutateFormDataUsing(function (array $data): array {
                    // Set user_id to current user
                    $data['user_id'] = auth()->id();
                    return $data;
                }),
        ];
    }

    protected function modalActions(): array
    {
        return [
            Actions\EditAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    // Ensure user_id is preserved
                    if (!isset($data['user_id'])) {
                        $data['user_id'] = auth()->id();
                    }
                    return $data;
                }),
            Actions\DeleteAction::make(),
        ];
    }

    public function fetchEvents(array $fetchInfo): array
    {
        return CalendarEvent::query()
            ->where('start', '>=', $fetchInfo['start'])
            ->where('start', '<=', $fetchInfo['end'])
            ->get()
            ->map(function (CalendarEvent $event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => $event->start->toIso8601String(),
                    'end' => $event->end?->toIso8601String(),
                    'allDay' => $event->all_day,
                    'backgroundColor' => $event->background_color ?? '#3b82f6',
                    'borderColor' => $event->background_color ?? '#3b82f6',
                ];
            })
            ->toArray();
    }

    public function getFormSchema(): array
    {
        return [
            Grid::make(2)
                ->schema([
                    TextInput::make('title')
                        ->label('Event Title')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(2),
                    
                    DateTimePicker::make('start')
                        ->label('Start Date & Time')
                        ->required()
                        ->seconds(false)
                        ->columnSpan(1),
                    
                    DateTimePicker::make('end')
                        ->label('End Date & Time')
                        ->seconds(false)
                        ->afterOrEqual('start')
                        ->columnSpan(1),
                    
                    Toggle::make('all_day')
                        ->label('All Day Event')
                        ->default(false)
                        ->columnSpan(2),
                    
                    ColorPicker::make('background_color')
                        ->label('Event Color')
                        ->columnSpan(2),
                    
                    Textarea::make('description')
                        ->label('Description')
                        ->rows(3)
                        ->columnSpan(2),
                ]),
        ];
    }

    public function resolveEventRecord(array $data): Model
    {
        return CalendarEvent::find($data['id']);
    }
}
