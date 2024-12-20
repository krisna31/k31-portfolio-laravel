<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendeCodeResource\Pages;
use App\Filament\Resources\AttendeCodeResource\RelationManagers;
use App\Models\AttendeCode;
use App\Models\User;
use Carbon\Carbon;
use Coolsam\FilamentFlatpickr\Forms\Components\Flatpickr;
use Filament\Actions\StaticAction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
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

    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'List Kode Presensi';
    protected static ?string $modelLabel = 'Kode Presensi';
    protected static ?string $pluralModelLabel = 'Kode Presensi';

    public ?string $tableSortColumn = 'start_date';

    public ?string $tableSortDirection = 'asc';

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
                    ->columnSpanFull()
                    ->searchDebounce(300)
                    ->loadingMessage('Loading attendence types...')
                    ->noSearchResultsMessage('No attendence types found')
                    ->createOptionForm(
                        fn(Form $form)
                        => AttendeTypeResource::form($form),
                    )
                    ->editOptionForm(
                        fn(Form $form)
                        => AttendeTypeResource::form($form),
                    ),
                Forms\Components\Select::make('user_id')
                    ->label('For User:')
                    ->relationship('user', 'name')
                    ->default(0)
                    ->placeholder('Select absent for:')
                    ->searchable()
                    ->preload()
                    ->columnSpanFull()
                    ->searchDebounce(500)
                    ->createOptionForm(
                        fn(Form $form)
                        => UserResource::form($form),
                    )
                    ->editOptionForm(
                        fn(Form $form)
                        => UserResource::form($form),
                    ),
                Forms\Components\Select::make('default_approval_status_id')
                    ->label('Default Approval Status For This Absence')
                    ->relationship('defaultApprovalStatus', 'name')
                    ->required()
                    ->placeholder('Select a default approval status')
                    ->searchable()
                    ->preload()
                    ->default(1)
                    ->columnSpanFull()
                    ->createOptionForm(
                        fn(Form $form)
                        => ApprovalStatusResource::form($form),
                    )
                    ->editOptionForm(
                        fn(Form $form)
                        => ApprovalStatusResource::form($form),
                    ),
                Forms\Components\TextInput::make('description')
                    ->label('Deskripsi')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('bulk_create')
                    ->label('Bulk Create?')
                    ->columnSpanFull()
                    ->live()
                    ->hidden(fn(string $operation): bool => $operation === 'edit'),
                Flatpickr::make('range_date')
                    ->label('Date To Create The Absence')
                    ->range()
                    ->required()
                    ->columnSpanFull()
                    ->hidden(fn(Get $get): bool => !$get('bulk_create')),
                Forms\Components\TimePicker::make('start_time')
                    ->label('Start Time')
                    ->time()
                    ->required()
                    ->hidden(fn(Get $get): bool => !$get('bulk_create')),
                Forms\Components\TimePicker::make('end_time')
                    ->label('Start Time')
                    ->time()
                    ->required()
                    ->hidden(fn(Get $get): bool => !$get('bulk_create')),
                Forms\Components\DateTimePicker::make('start_date')
                    ->label('Start Date Time')
                    ->required()
                    ->native(false)
                    ->weekStartsOnMonday()
                    // ->afterOrEqual('today')
                    ->default(Carbon::now()->toDateTimeString())
                    ->hidden(fn(Get $get): bool => $get('bulk_create')),
                Forms\Components\DateTimePicker::make('end_date')
                    ->label('End Date Time')
                    ->required()
                    ->native(false)
                    ->weekStartsOnMonday()
                    ->after('start_date')
                    ->hidden(fn(Get $get): bool => $get('bulk_create')),
                Forms\Components\TextInput::make('radius')
                    ->label('Geofence Radius (in meters)')
                    ->type('number')
                    ->rules(['numeric', 'min:0', 'max:100000'])
                    ->requiredWith('location')
                    ->step(1)
                    ->columnSpanFull(),
                Forms\Components\Select::make('location')
                    ->label('Location')
                    ->options([
                        '-2.944841#104.756658' => 'Kantor Perusahaan',
                    ])
                    ->requiredWith('radius')
                    ->native(false)
                    ->columnSpanFull(),
                // Forms\Components\TextInput::make('latitude')
                //     ->label('Geofence Latitude')
                //     ->type('number')
                //     ->rules(['numeric', 'min:-90', 'max:90'])
                //     ->requiredWith('radius,longitude')
                //     ->step(0.000001),
                // Forms\Components\TextInput::make('longitude')
                //     ->label('Geofence Longitude')
                //     ->type('number')
                //     ->rules(['numeric', 'min:-180', 'max:180'])
                //     ->requiredWith('radius,latitude')
                //     ->step(0.000001),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('ID copied')
                    ->copyMessageDuration(1500)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('For User')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('attendeType.name')
                    ->label('Attendence Type')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('defaultApprovalStatus.name')
                    ->label('Default Approval Status')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('description')
                    ->html()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('start_date')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('end_date')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('radius')
                    ->label('Geofence Radius')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('latitude')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('longitude')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
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
                    })
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_by')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_by')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_by')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
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
                            ->default('all'),
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
                        // ->default(now())
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
                Tables\Actions\ActionGroup::make([
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
                    Tables\Actions\DeleteAction::make()
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Attende Code Deleted')
                                ->body('The attende code was deleted successfully.'),
                        ),
                    Tables\Actions\ReplicateAction::make()
                        ->successNotificationTitle('Attende Code Replicated'),
                    Tables\Actions\RestoreAction::make(),
                ])
                    ->link()
                    ->label('Actions'),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
                \AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction::make('Export Terpilih'),
                Tables\Actions\RestoreBulkAction::make(),
                // ]),
            ])
            ->headerActions([
                \AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction::make('Export Semua')
                    ->color('info'),
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
            'create' => Pages\CreateAttendeCode::route('/create'),
            'edit' => Pages\EditAttendeCode::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 10 ? 'warning' : 'primary';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['attendeType.name', 'description', 'start_date', 'end_date'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'name' => $record->attendeType->name,
            'description' => $record->description,
            'start_date' => $record->start_date,
            'end_date' => $record->end_date,
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()
            ->with('attendeType');
    }

    public static function getEloquentQuery(): Builder {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
