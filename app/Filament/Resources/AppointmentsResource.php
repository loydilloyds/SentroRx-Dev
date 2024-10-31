<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentsResource\Pages;
use App\Filament\Resources\AppointmentsResource\RelationManagers;
use App\Models\Appointment;
use App\Models\Appointments;
use App\Models\Doctor;
use App\Models\HealthCenter;
use App\Models\User;
use Doctrine\DBAL\Query\QueryBuilder;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AppointmentsResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->schema([
                        TextInput::make('firstName')
                            ->label('First Name')
                            ->readOnly(),
                        TextInput::make('middleName')
                            ->label('Middle Name')
                            ->readonly(),
                        TextInput::make('lastName')
                            ->label('Last Name')
                            ->readonly(),
                    ])
                    ->relationship('user')
                    ->columns(3),
                Grid::make()
                    ->columns(2)
                    ->schema([
                        Select::make('health_center_id')
                            ->label('Barangay Health Center')
                            ->relationship('health_center', 'name')
                            ->createOptionUsing(fn ($healthCenter) => $healthCenter->getKey())
                            ->required(),
                        Select::make('doctor_id')
                            ->label('Doctor')
                            ->relationship('doctor', 'id')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->user->firstName} {$record->user->middleName} {$record->user->lastName}")
                            ->createOptionUsing(fn ($doctor) => $doctor->user_id)
                            ->required(),
                    ]),
                Grid::make()
                    ->schema([
                        DatePicker::make('date')
                            ->label('Date')
                            ->afterStateUpdated(fn (Set $set) => $set('status', "adjusted"))
                            ->live(onBlur: true)
                            ->required(),
                        TimePicker::make('time')
                            ->label('Time')
                            ->afterStateUpdated(fn (Set $set) => $set('status', "adjusted"))
                            ->live(onBlur: true)
                            ->required(),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                "approved" => "Approved",
                                "cancelled" => "Cancelled",
                                "adjusted" => "Adjusted",
                            ])
                            ->required(),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('index')
                    ->rowIndex(),
                TextColumn::make('date')
                    ->label('Date')
                    ->date('F d, Y'),
                TextColumn::make('time')
                    ->label('Time')
                    ->time('h:i:s A'),
                TextColumn::make('doctor')
                    ->label('Doctor')
                    ->formatStateUsing(function ($state) {
                        $doctor = "Dr. ";
                        $doctor .= $state->user->firstName ?? '';
                        $doctor .= $state->user->lastName ??  '';
                        return $doctor === "Dr. " ? '' : $doctor;
                    }),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => ucfirst($state))
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'success',
                        'cancelled' => 'danger',
                        'adjusted' => 'warning',
                        'pending' => 'info',
                    }),
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn ($query): Builder => $query->where('status', 'pending'))
            ->defaultSort('date', 'desc');
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
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointments::route('/create'),
            'edit' => Pages\EditAppointments::route('/{record}/edit'),
        ];
    }
}
