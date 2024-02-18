<?php

namespace App\Livewire;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class AbsenceModal extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public $attendeCode;

    public function mount($attendeCode): void
    {
        $this->attendeCode = $attendeCode;
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('attende_status_id')
                    ->options(fn(): array => \App\Models\AttendeStatus::pluck('name', 'id')->toArray())
                    ->label('Select Attende Status For This Absence')
                    ->required()
                    ->placeholder('Select a default approval status')
                    ->searchable()
                    ->preload()
                    ->columnSpanFull(),
                FileUpload::make('photo')
                    ->label('Photo')
                    ->required()
                    ->multiple()
                    ->imageEditor()
                    ->directory('attende-photos')
                    ->columnSpanFull(),
                TextInput::make('latitude')
                    ->label('Latitude')
                    // ->visible(false)
                    // ->disabled()
                    ->extraAttributes([
                        'id' => 'latitude',
                    ], true)
                // ->required(),
                ,
                TextInput::make('longitude')
                    ->label('Longitude')
                    // ->visible(false)
                    // ->disabled()
                    ->extraAttributes([
                        'id' => 'longitude',
                    ], true)
                // ->required(),
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        dd($this->form->getState());
    }

    public function render()
    {
        return view('livewire.absence-modal', [
            'attendeCode' => $this->attendeCode,
        ]);
    }
}
