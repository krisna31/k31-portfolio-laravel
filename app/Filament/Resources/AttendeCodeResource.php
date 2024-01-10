<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendeCodeResource\Pages;
use App\Filament\Resources\AttendeCodeResource\RelationManagers;
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
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use stdClass;

class AttendeCodeResource extends Resource
{
    protected static ?string $model = AttendeCode::class;

    protected static ?string $navigationIcon = 'heroicon-o-qr-code';

    protected static ?string $navigationGroup = 'Employee Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('attende_type_id')
                    ->label('Attendence Type')
                    ->relationship('attendeType', 'name')
                    ->required()
                    ->placeholder('Select a attendence type')
                    ->searchable()
                    ->preload()
                    ->columnSpanFull(),
                // Forms\Components\TextInput::make('code')
                //     ->required()
                //     ->maxLength(255),
                Forms\Components\RichEditor::make('description')
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('start_date')
                    ->required()
                    ->seconds(false)
                    ->native(false)
                    ->weekStartsOnMonday()
                    ->afterOrEqual('today'),
                Forms\Components\DateTimePicker::make('end_date')
                    ->required()
                    ->seconds(false)
                    ->native(false)
                    ->weekStartsOnMonday()
                    ->after('start_date'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('No')->state(
                    static function (Tables\Contracts\HasTable $livewire, stdClass $rowLoop): string {
                        return (string) (
                            $rowLoop->iteration +
                            ($livewire->getTableRecordsPerPage() * (
                                $livewire->getTablePage() - 1
                            ))
                        );
                    }
                ),
                Tables\Columns\TextColumn::make('attendeType.name')
                    ->label('Attendence Type')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('description')
                    ->html()
                    ->searchable(),
                Tables\Columns\IconColumn::make('status')
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
                Tables\Columns\TextColumn::make('start_date')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('end_date')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('status')
                    ->label('Status')
                    ->form([
                        Forms\Components\Select::make('status')
                            ->options([
                                'finished' => 'Finished',
                                'active' => 'Active',
                                'upcoming' => 'Upcoming',
                            ])
                            ->placeholder('Select a status')
                            ->preload()
                            ->default('active'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $now = Carbon::now()->toDateTimeString();
                        return $query
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
                                fn(Builder $query): Builder => $query->where('start_date', '>', Carbon::now()),
                            );
                    })
                    ->indicateUsing(fn(array $data): ?string => match ($data['status'] ?? null) {
                        'finished' => 'Absence is Finished',
                        'active' => 'Absence is Active',
                        'upcoming' => 'Absence is Upcoming',
                        default => null,
                    }),
                Filter::make('created_at')
                    ->label('Created At')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until')
                            ->default(now()),
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
                Tables\Actions\Action::make('Qr Code')
                    ->icon('heroicon-o-qr-code')
                    ->modalContent(
                        fn(AttendeCode $record): View => view(
                            'filament.admin.attende-code-resources.qr-code',
                            ['record' => $record],
                        )
                    )
                    ->color('success')
                    ->modalCancelAction(fn(StaticAction $action) => $action->label('Close'))
                    ->modalSubmitAction(false)
                    ->visible(fn(AttendeCode $record): bool => Carbon::now()->between(Carbon::parse($record->start_date), Carbon::parse($record->end_date))),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            // ->recordClasses(function (AttendeCode $record) {
            //     $now = Carbon::now();
            //     $startDate = Carbon::parse($record->start_date);
            //     $endDate = Carbon::parse($record->end_date);

            //     if ($now->lt($startDate)) {
            //         return 'border-s-2 border-red-600 dark:border-red-300';
            //     } elseif ($now->between($startDate, $endDate)) {
            //         return 'border-s-2 border-green-600 dark:border-green-300';
            //     } elseif ($now->gt($endDate)) {
            //         return 'border-s-2 border-orange-600 dark:border-orange-300';
            //     }

            //     return null;
            // });
            ->striped()
            ->defaultSort('start_date', 'desc');
        ;
        ;
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
            'create' => Pages\CreateAttendeCode::route('/create'),
            'edit' => Pages\EditAttendeCode::route('/{record}/edit'),
        ];
    }
}
