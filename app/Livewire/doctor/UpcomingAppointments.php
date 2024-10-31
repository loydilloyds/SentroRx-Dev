<?php

namespace App\Livewire\doctor;

use Livewire\Component;
use App\Models\Appointment;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class UpcomingAppointments extends Component implements HasForms, HasTable
{
    use InteractsWithTable, InteractsWithForms;
    public function render()
    {
        return view('livewire.doctor.upcoming-appointments');
    }

    public function table(Table $table) : Table
    {
        return $table
            ->query(Appointment::query()
                ->where([
                    ['doctor_id', Auth::user()->id],
                    ['date', '>=', now()->startOfDay()],
                ])
            )
            ->columns([
                TextColumn::make('index')
                    ->rowIndex(),
                TextColumn::make('user')
                    ->label('Patient')
                    ->formatStateUsing(function ($state) {
                        return "{$state->firstName} {$state->middleName} {$state->lastName}";
                    }),
                TextColumn::make('date')
                    ->label('Date')
                    ->date('F d, Y'),
                TextColumn::make('time')
                    ->label('Time')
                    ->time('h:i:s A'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(function (Appointment $record) : string {
                        return time() > strtotime($record->time) ? 'Ongoing' : ucfirst($record->status);
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'success',
                        'cancelled' => 'danger',
                        'adjusted' => 'warning',
                        'pending' => 'info',
                        'ongoing' => 'primary',
                    }),
            ])
            ->defaultSort('date', 'asc')
            ->filters([
                // ...
            ])
            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ]);
    }
}
