<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NotificationsResource\Pages;
use App\Filament\Resources\NotificationsResource\RelationManagers;
use App\Models\Notification;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Table;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\Grid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\HasMedia;
use Symfony\Component\Console\Input\Input;

class NotificationsResource extends Resource
{
    protected static ?string $model = Notification::class;

    protected static ?string $navigationIcon = 'heroicon-o-bell';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Grid::make()
                ->schema([
                    TextInput::make('title')
                    ->label('Title')
                    ->required(),
                ])
                ->columns(1),

                Grid::make()
                ->schema([
                    Textarea::make('content')
                    ->label('Content')
                    ->required(),
                ])
                ->columns(1),

                Grid::make()
                ->schema([
                    FileUpload::make('image')
                        ->label('Image'),

                    Select::make('recipients')
                    ->label('Recipient Types')
                    ->options([
                        "allUsers" => "All Users",
                        "patients" => "Patients",
                        "doctors" => "Doctors",
                        "custom" => "Custom",
                    ])
                    ->default('allUsers')
                    ->live()
                    ->required(),
                ])
                ->columns(2),

                Grid::make()
                ->schema([
                    TagsInput::make('recipientId')
                        ->label('Recipients Names')
                        ->visible(function (Get $get) {
                            return $get('recipients') == "custom";
                        })

                        ->suggestions(function (Get $get) {
                            return DB::table('users')
                                ->pluck('firstName', 'id')
                                ->toArray();
                        })

                        ->separator(',')
                        ->required(),
                ])
                ->columns(1),

                Toggle::make('isAnnouncement')
                ->label('Make as Announcement'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->limit(20),
                TextColumn::make('content')
                    ->limit(20),
                ImageColumn::make('image'),
                TextColumn::make('recipients'),
                IconColumn::make('isAnnouncement')
                ->label('Announcement')
                ->boolean()
                ->alignment(Alignment::Center)
                ->trueColor('info')
                ->falseColor('warning'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNotifications::route('/'),
            'create' => Pages\CreateNotifications::route('/create'),
            'edit' => Pages\EditNotifications::route('/{record}/edit'),
        ];
    }
}
