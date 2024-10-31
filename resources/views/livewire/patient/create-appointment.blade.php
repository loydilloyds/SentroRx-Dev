<div class="text-gray-700">
    <form wire:submit="create">
        {{ $this->form }}

        <x-primary-button type="submit" class="mt-16 bg-srx-blue">
            Submit
        </x-primary-button>
    </form>

    <x-filament-actions::modals />
</div>
