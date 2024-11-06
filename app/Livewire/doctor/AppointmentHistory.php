<?php

namespace App\Livewire\doctor;

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
    public string $tableName = 'appointment-history-oipbrz-table';
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
            ->whereHas('doctor', function (Builder $query) {
                $query->where([
                    ['user_id', Auth::id()],
                    ['date', '<', \Carbon\Carbon::now()],
                    ['status', '<>', 'pending'],
                ]);
            })
            ->join('users', 'appointments.user_id', '=', 'users.id')
            ->select('appointments.*', 'users.firstName', 'users.lastName');
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

            Column::make('First Name', 'firstName')
                ->searchable()
                ->sortable(),

            Column::make('Last Name', 'lastName')
                ->searchable()
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
            Filter::datepicker('created_at_formatted', 'created_at'),
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
//
//            Button::add('edit')
//                ->slot('Edit: '.$row->id)
//                ->id()
//                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
//                ->dispatch('edit', ['rowId' => $row->id])
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
