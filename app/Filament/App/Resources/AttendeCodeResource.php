<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\AttendeCodeResource\Pages;
use App\Filament\App\Resources\AttendeCodeResource\RelationManagers;
use App\Filament\App\Resources\AttendeCodeResource as AdminAttendeCodeResource;
use App\Models\AttendeCode;
use Carbon\Carbon;
use Filament\Actions\StaticAction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendeCodeResource extends Resource
{
    protected static ?string $model = AttendeCode::class;

    protected static ?string $navigationIcon = 'heroicon-o-qr-code';

    protected static ?string $navigationGroup = 'Presence';

    protected static ?string $navigationLabel = 'Absences';

    protected static ?int $navigationSort = 1;

    public ?string $tableSortColumn = 'start_date';

    public ?string $tableSortDirection = 'asc';

    public static function form(Form $form): Form
    {
        return AdminAttendeCodeResource::form($form);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('attendeType.name')
                    ->label('Attendence Type')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->html()
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('end_date')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('attendes.approvalStatus.name')
                    ->label('Absence Status')
                    ->default('Belum Melakukan Absen')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('status')
                    ->label('Absence Open?')
                    ->default('Belum Melakukan Absen')
                    ->sortable()
                    ->searchable()
                    ->state(function (AttendeCode $record): string {
                        $now = Carbon::now();
                        $startDate = Carbon::parse($record->start_date);
                        $endDate = Carbon::parse($record->end_date);

                        return match (true) {
                            $now->between($startDate, $endDate) => 'between_start_and_end',
                            $endDate->lt($now) => 'before_start',
                            $endDate->gt($now) => 'after_end',
                            default => 'default',
                        };
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        'before_start' => 'heroicon-o-x-circle',
                        'between_start_and_end' => 'heroicon-o-check-circle',
                        'after_end' => 'heroicon-o-clock',
                        default => 'heroicon-o-no-symbol',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'before_start' => 'gray',
                        'between_start_and_end' => 'success',
                        'after_end' => 'warning',
                        default => 'gray',
                    }),
            ])
            ->filters([
                Filter::make('status')
                    ->label('Status')
                    ->form([
                        Forms\Components\Select::make('status')
                            ->options([
                                'all' => 'All',
                                'finished' => 'Finished',
                                'active' => 'Active',
                                'upcoming' => 'Upcoming',
                                'active_or_upcoming' => 'Active & Upcoming',
                            ])
                            ->placeholder('Select a status')
                            ->preload()
                            ->default('active_or_upcoming'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $now = Carbon::now()->toDateTimeString();
                        return $query
                            ->when(
                                $data['status'] === 'all',
                                fn(Builder $query): Builder => $query,
                            )
                            ->when(
                                $data['status'] === 'active_or_upcoming',
                                fn(Builder $query): Builder => $query->where(
                                    fn(Builder $query): Builder =>
                                    $query->where('end_date', '>=', $now)
                                ),
                            )
                            ->when(
                                $data['status'] === 'finished',
                                fn(Builder $query): Builder => $query->where('end_date', '<', $now),
                            )
                            ->when(
                                $data['status'] === 'active',
                                fn(Builder $query): Builder => $query->where(
                                    fn(Builder $query): Builder => $query
                                        ->where('start_date', '<=', $now)
                                        ->where('end_date', '>=', $now),
                                )
                            )
                            ->when(
                                $data['status'] === 'upcoming',
                                fn(Builder $query): Builder =>
                                $query->where('start_date', '>', Carbon::now()),
                            );
                    })
                    ->indicateUsing(fn(array $data): ?string => match ($data['status'] ?? null) {
                        'all' => 'All Absences',
                        'finished' => 'Absence is Finished',
                        'active' => 'Absence is Active',
                        'upcoming' => 'Absence is Upcoming',
                        'active_or_upcoming' => 'Absence is Active or Upcoming',
                        default => null,
                    }),
                Filter::make('created_at')
                    ->label('Created At')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until')
                            ->default(now())
                        ,
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['created_from'] ?? null) {
                            $indicators[] = Indicator::make('Created from ' . Carbon::parse($data['created_from'])->toFormattedDateString())
                                ->removeField('from');
                        }

                        if ($data['created_until'] ?? null) {
                            $indicators[] = Indicator::make('Created until ' . Carbon::parse($data['created_until'])->toFormattedDateString())
                                ->removeField('until');
                        }

                        return $indicators;
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('view-information')
                    ->label('Detail')
                    ->icon('heroicon-o-information-circle')
                    ->color('primary')
                    ->infolist([
                        \Filament\Infolists\Components\TextEntry::make('start_date'),
                        \Filament\Infolists\Components\TextEntry::make('end_date'),
                        \Filament\Infolists\Components\TextEntry::make('description')
                            ->html(),
                        \Filament\Infolists\Components\TextEntry::make('attendeType.name'),
                    ])
                    ->modalAlignment(\Filament\Support\Enums\Alignment::Center)
                    ->modalCancelAction(false)
                    ->modalSubmitAction(false),
                Tables\Actions\Action::make('absence')
                    ->label('Absence')
                    ->icon('heroicon-o-viewfinder-circle')
                    ->fillForm(function (AttendeCode $record): array {
                        return [
                            'user_id' => auth()->user()->id,
                            'attende_code_id' => $record->id,
                            'approval_status_id' => $record->default_approval_status_id,
                        ];
                    })
                    ->extraAttributes([
                        'id' => 'btn-absence',
                    ])
                    ->form([
                        Forms\Components\Select::make('attende_status_id')
                            ->options(fn(): array => \App\Models\AttendeStatus::pluck('name', 'id')->toArray())
                            ->label('Select Attende Status For This Absence')
                            ->required()
                            ->placeholder('Select a default approval status')
                            ->searchable()
                            ->preload()
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('photo')
                            ->label('Photo')
                            ->required()
                            ->multiple()
                            ->imageEditor()
                            ->directory('attende-photos')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('latitude')
                            ->label('Latitude')
                            // ->visible(false)
                            ->disabled()
                            ->dehydrated()
                            ->extraAttributes([
                                'id' => 'latitude',
                            ], true)
                            ->required(),
                        Forms\Components\TextInput::make('longitude')
                            ->label('Longitude')
                            // ->visible(false)
                            ->disabled()
                            ->dehydrated()
                            ->extraAttributes([
                                'id' => 'longitude',
                            ], true)
                            ->required(),
                    ])
                    ->action(function (array $data, AttendeCode $record): void {
                        $insertedData = [
                            'user_id' => auth()->user()->id,
                            'attende_code_id' => $record->id,
                            'approval_status_id' => $record->default_approval_status_id,
                            'attende_status_id' => $data['attende_status_id'],
                            'attende_time' => Carbon::now(),
                            'photo' => $data['photo'],
                            'latitude' => $data['latitude'],
                            'longitude' => $data['longitude'],
                        ];

                        \App\Models\Attende::create($insertedData);
                    })
                    ->color('danger')
                    ->modalCancelAction(fn(StaticAction $action) => $action->label('Close'))
                    ->modalSubmitAction(fn(StaticAction $action) =>
                        $action
                            ->label('Submit'))
                    ->visible(fn(AttendeCode $record): bool => Carbon::now()->between(Carbon::parse($record->start_date), Carbon::parse($record->end_date)) && !\App\Models\Attende::where('attende_code_id', $record->id)->where('user_id', auth()->id())->exists()),
                Tables\Actions\Action::make('not-done-absence-info')
                    ->label('Absence Info')
                    ->icon('heroicon-o-information-circle')
                    ->modalContent(view('filament.app.attende.info-modal'))
                    ->modalSubmitAction(false)
                    ->modalAlignment(\Filament\Support\Enums\Alignment::Center)
                    ->modalCancelAction(false)
                    ->visible(fn(AttendeCode $record): bool => !Carbon::now()->between(Carbon::parse($record->start_date), Carbon::parse($record->end_date))),
                Tables\Actions\Action::make('success-absence-info')
                    ->label('Absence Info')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->modalContent(view('filament.app.attende.success-absence-info-modal'))
                    ->modalSubmitAction(false)
                    ->modalAlignment(\Filament\Support\Enums\Alignment::Center)
                    ->modalCancelAction(false)
                    ->visible(fn(AttendeCode $record): bool => \App\Models\Attende::where('attende_code_id', $record->id)->where('user_id', auth()->id())->exists()),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])
            ->striped()
            ->defaultSort('start_date', 'asc')
            ->persistSortInSession();
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
            'index' => Pages\ListAttendeCodes::route('/'),
            // 'view' => Pages\ViewAttendeCode::route('/{record}'),
            // 'create' => Pages\CreateAttendeCode::route('/create'),
            // 'edit' => Pages\EditAttendeCode::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id())
            ->orWhere('user_id', 0)
            ->withoutGlobalScope(SoftDeletingScope::class);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('user_id', auth()->id())->orWhere('user_id', 0)->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::where('user_id', auth()->id())->orWhere('user_id', 0)->count() > 10 ? 'warning' : 'primary';
    }
}
