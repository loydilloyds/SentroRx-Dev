<?php

namespace App\Services;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Set;

final class AppointmentDetailsForm
{
    public static function schema() : array
    {
        return [
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
        ];
    }
}
