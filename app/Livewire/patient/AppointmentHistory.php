<?php

namespace App\Livewire\patient;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class AppointmentHistory extends PowerGridComponent
{
    public string $tableName = 'appointment-history-l2to6d-table';
    public string $sortField = 'date';
    public string $sortDirection = 'desc';

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Appointment::query()
            ->where([
                ['user_id', Auth::id()],
                ['date', '<', Carbon::now()->format("m/d/Y")],
                ['status', '<>', 'pending']
            ]);
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('date', fn (Appointment $appointment) => Carbon::parse($appointment->date)->format('m/d/Y'))
            ->add('time', fn (Appointment $appointment) => Carbon::parse($appointment->time)->format('h:i A'))
            ->add('status', function (Appointment $appointment) {
                return Blade::render('<x-status-bar :status="$status"/>', ['status' => $appointment->status]);
            }
            );
    }

    public function columns(): array
    {
        return [
            Column::make('Index', '')
                ->index()
                ->sortable(),

            Column::make('Status', 'status')
                ->searchable()
                ->sortable(),

            Column::make('Date', 'date')
                ->searchable()
                ->sortable(),

            Column::make('Time', 'time')
                ->sortable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('name'),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }

    public function actions(Appointment $row): array
    {
        return [
            Button::add('view')
                ->slot('View Details')
                ->class('appointment-action-button')
                ->dispatch('edit', ['rowId' => $row->id]),
        ];
    }

    public function actionRules(Appointment $row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }

}
