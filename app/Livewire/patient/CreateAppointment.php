<?php

namespace App\Livewire\patient;

use App\Models\Appointment;
use App\Models\HealthCenter;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateAppointment extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = []; // this is where we store the data
    private string $firstName = '';
    private string $middleName = '';
    private string $lastName = '';

    public function mount(): void
    {
        $this->firstName = Auth::user()->firstName;
        $this->middleName = Auth::user()->middleName;
        $this->lastName = Auth::user()->lastName;
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->schema([
                        TextInput::make('firstName')
                            ->label('First Name')
                            ->default($this->firstName)
                            ->readOnly(),
                        TextInput::make('middleName')
                            ->label('Middle Name')
                            ->default($this->middleName)
                            ->readonly(),
                        TextInput::make('lastName')
                            ->label('Last Name')
                            ->default($this->lastName)
                            ->readonly(),
                    ])
                    ->columns(3),
                Select::make('health_center')
                    ->label('Barangay Health Center')
                    ->options(HealthCenter::all()->pluck('name', 'id'))
                    ->columnSpanFull()
                    ->required(),
                Grid::make()
                    ->schema([
                        DatePicker::make('date')
                            ->label('Date')
                            ->required(),
                        TimePicker::make('time')
                            ->label('Time')
                            ->required(),
                    ])
                    ->columns(2),
            ])
            ->model(Appointment::class)
            ->statePath('data');
    }

    // Validate and pass form data
    public function create()
    {
        $appointment = new Appointment([
            'status' => 'pending',
            'date' => $this->data['date'],
            'time' => $this->data['time'],
        ]);

        $appointment->user()->associate(Auth::user());
        $appointment->health_center()->associate($this->data['health_center']);

        $appointment->save();
        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.patient.create-appointment');
    }
}
