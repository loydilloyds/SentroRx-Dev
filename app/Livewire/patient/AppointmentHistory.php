<?php

namespace App\Livewire\patient;

use App\Models\Appointment;
use App\Services\AppointmentDetailsForm;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AppointmentHistory extends Component implements HasForms, HasTable
{
    use InteractsWithTable, InteractsWithForms;
    public function render() : View
    {
        return view('livewire.patient.appointment-history');
    }

    public function table(Table $table) : Table
    {
        return $table
            ->query(Appointment::query()
                        ->where('user_id', Auth::user()->id)
                    )
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
                        $doctor .= $state->user->firstName ?? ' ';
                        $doctor .= $state->user->lastName ??  ' ';
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
            ->defaultSort('date', 'desc')
            ->filters([
                // ...
            ])
            ->actions([

            ])
            ->bulkActions([
                // ...
            ]);
    }
}
