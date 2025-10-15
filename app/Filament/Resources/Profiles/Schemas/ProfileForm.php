<?php

namespace App\Filament\Resources\Profiles\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Basic Information')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('age')
                            ->required()
                            ->numeric()
                            ->minValue(18)
                            ->maxValue(100),
                        \Filament\Forms\Components\Toggle::make('active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('When disabled, this profile will not be displayed on the frontend'),
                        // Legacy image field - hidden but kept for backward compatibility
                        // FileUpload::make('image')
                        //     ->label('Main Image (Legacy)')
                        //     ->image()
                        //     ->directory('profiles')
                        //     ->visibility('public')
                        //     ->helperText('This is the legacy single image field. Use the multiple images section below for new uploads.'),
                    ]),

                Section::make('Profile Images')
                    ->description('Upload multiple images for this profile. Drag and drop files or click to browse.')
                    ->schema([
                        FileUpload::make('images')
                            ->label('Profile Images')
                            ->multiple()
                            ->image()
                            ->disk('public')
                            ->directory('profiles')
                            ->visibility('public')
                            ->reorderable()
                            ->appendFiles()
                            ->maxFiles(10)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->helperText('Upload up to 10 images. Drag and drop or click to browse. You can reorder images by dragging them.')
                            ->live()
                            ->afterStateUpdated(function ($state, $set, $get) {
                                // Auto-set main image if not set and images exist
                                if (!$get('main_image') && $state && is_array($state) && count($state) > 0) {
                                    // Don't set main_image here as it will be a temporary path
                                    // The main_image should be set after files are processed and saved
                                }
                            }),
                        
                        Select::make('main_image')
                            ->label('Main Image')
                            ->options(function ($get) {
                                $options = [];
                                $images = $get('images');
                                if ($images && is_array($images)) {
                                    foreach ($images as $image) {
                                        // Handle both TemporaryUploadedFile objects and string paths
                                        if (is_object($image)) {
                                            // For TemporaryUploadedFile objects, use the temporary path
                                            $imagePath = $image->path();
                                            $options[$imagePath] = $image->getClientOriginalName();
                                        } else {
                                            // For string paths (already saved files)
                                            $options[$image] = basename($image);
                                        }
                                    }
                                }
                                return $options;
                            })
                            ->searchable()
                            ->helperText('Select which image should be the main profile image. This will be displayed first on the frontend.')
                            ->live()
                            ->reactive(),
                    ])
                    ->columns(1),

                Section::make('Additional Details')
                    ->columns(1)
                    ->schema([
                        Textarea::make('description')
                            ->rows(4)
                            ->placeholder('Persönliche Beschreibung des Profils...'),
                        TagsInput::make('languages')
                            ->placeholder('Sprachen hinzufügen...')
                            ->helperText('Drücken Sie Enter nach jeder Sprache'),
                    ]),

                Section::make('Physical Attributes')
                    ->columns(4)
                    ->schema([
                        TextInput::make('height')
                            ->numeric()
                            ->suffix('cm')
                            ->placeholder('z.B. 165'),
                        TextInput::make('bust_size')
                            ->placeholder('z.B. 80 C'),
                        TextInput::make('body_type')
                            ->placeholder('z.B. Latina'),
                        TextInput::make('origin')
                            ->placeholder('z.B. Chile'),
                        TextInput::make('clothing_size')
                            ->placeholder('z.B. 36/38'),
                        TextInput::make('weight')
                            ->numeric()
                            ->suffix('kg'),
                        TextInput::make('shoe_size')
                            ->numeric()
                            ->placeholder('z.B. 36'),
                        TextInput::make('intimate_area')
                            ->placeholder('z.B. total rasiert'),
                        TextInput::make('hair')
                            ->placeholder('z.B. brünett, rückenlang'),
                        TextInput::make('eyes')
                            ->placeholder('z.B. braun'),
                        TextInput::make('skin')
                            ->placeholder('z.B. mittel'),
                        TextInput::make('body_jewelry')
                            ->placeholder('z.B. Tattoos'),
                    ]),

                Section::make('Services & Options')
                    ->columns(2)
                    ->schema([
                        TagsInput::make('intercourse_options')
                            ->label('Verkehr')
                            ->placeholder('Verkehrsoptionen hinzufügen...')
                            ->helperText('z.B. GV, Franz., etc.'),
                        TagsInput::make('services_for')
                            ->label('Service für')
                            ->placeholder('Zielgruppe hinzufügen...')
                            ->helperText('z.B. Herren, Paare, etc.'),
                        TagsInput::make('services')
                            ->label('Services')
                            ->placeholder('Service hinzufügen...')
                            ->helperText('z.B. Schmusen, Kuscheln, etc.'),
                        TagsInput::make('massages')
                            ->label('Massagen')
                            ->placeholder('Massageart hinzufügen...')
                            ->helperText('z.B. erot. Massagen, Body-to-Body, etc.'),
                        TagsInput::make('meetings')
                            ->label('Treffen')
                            ->placeholder('Treffenoption hinzufügen...')
                            ->helperText('z.B. mit Termin, ohne Termin'),
                        TextInput::make('other')
                            ->label('Andere Informationen')
                            ->placeholder('z.B. Nichtraucher')
                            ->helperText('z.B. Nichtraucher'),
                    ]),

                Section::make('Schedule & Additional Info')
                    ->columns(1)
                    ->schema([
                        Textarea::make('schedule')
                            ->label('Zeiten')
                            ->rows(6)
                            ->placeholder('Arbeitszeiten eingeben...')
                            ->helperText('z.B. Montag: 10:00 - 21:30 Uhr'),
                        Textarea::make('additional_info')
                            ->label('Zusätzliche Informationen')
                            ->rows(3)
                            ->placeholder('Weitere Informationen...'),
                    ]),
            ]);
    }
}
