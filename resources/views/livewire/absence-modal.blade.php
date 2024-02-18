<div>
    <div
    x-data="{}"
    x-load-js="[@js(\Filament\Support\Facades\FilamentAsset::getScriptSrc('custom-lat-long-attende-js'))]"></div>
    <x-slot name="heading">
        Absence Form
    </x-slot>

    <x-slot name="description">
        This is a form to submit an absence request.
    </x-slot>

    {{-- Modal content --}}
    <form wire:submit="create">
        {{ $this->form }}

        <button type="submit">
            Submit
        </button>
    </form>
    {{-- End of modal content --}}
</div>
