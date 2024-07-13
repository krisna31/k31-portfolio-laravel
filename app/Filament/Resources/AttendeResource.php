<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendeResource\Pages;
use App\Filament\Resources\AttendeResource\RelationManagers;
use App\Models\Attende;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendeResource extends Resource {
    protected static ?string $model = Attende::class;
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';
    protected static ?string $navigationGroup = 'Employee Management';
    protected static ?string $modelLabel = 'Presensi';
    protected static ?string $pluralModelLabel = 'Presensi';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Presensi';

    public static function form(Form $form): Form {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('For User:')
                    ->relationship('user', 'name')
                    ->placeholder('Select absent for:')
                    ->searchable()
                    ->preload()
                    ->columnSpanFull()
                    ->searchDebounce(500)
                    ->required()
                    ->createOptionForm(
                        fn (Form $form)
                        => UserResource::form($form),
                    )
                    ->editOptionForm(
                        fn (Form $form)
                        => UserResource::form($form),
                    ),
                Forms\Components\Select::make('attende_code_id')
                    ->label('Attende Code')
                    ->relationship('attendeCode', 'id')
                    ->placeholder('Absent for id:')
                    ->searchable()
                    ->preload()
                    ->columnSpanFull()
                    ->searchDebounce(500)
                    // ->createOptionForm(
                    //     fn(Form $form)
                    //     => AttendeCodeResource::form($form),
                    // )
                    // ->editOptionForm(
                    //     fn(Form $form)
                    //     => AttendeCodeResource::form($form),
                    // )
                    ->required(),
                Forms\Components\Select::make('approval_status_id')
                    ->label('Approval Status For This Absence')
                    ->relationship('approvalStatus', 'name')
                    ->required()
                    ->placeholder('Select a approval status')
                    ->searchable()
                    ->preload()
                    ->default(1)
                    ->columnSpanFull()
                    // ->disabled(fn (string $operation): bool => $operation === 'edit')
                    ->createOptionForm(
                        fn (Form $form)
                        => ApprovalStatusResource::form($form),
                    )
                    ->editOptionForm(
                        fn (Form $form)
                        => ApprovalStatusResource::form($form),
                    ),
                Forms\Components\Select::make('attende_status_id')
                    ->label('Select Attende Status For This Absence')
                    ->relationship('attendeStatus', 'name')
                    ->required()
                    ->placeholder('Select a default approval status')
                    ->searchable()
                    ->preload()
                    ->default(1)
                    ->columnSpanFull()
                    ->createOptionForm(
                        fn (Form $form)
                        => AttendeStatusResource::form($form),
                    )
                    ->editOptionForm(
                        fn (Form $form)
                        => AttendeStatusResource::form($form),
                    ),
                Forms\Components\DateTimePicker::make('attende_time')
                    ->label('Attende Time')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('address')
                    ->label('Address')
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
                    // ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('longitude')
                    ->label('Longitude')
                    // ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('attende_time')
                    // ->dateTime()
                    ->sortable()
                    ->default('empty')
                    ->formatStateUsing(fn (string $state, Attende $record): string =>
                        $state != 'empty' ?
                            Carbon::parse($state)->format('d-m-Y H:i:s') . " (" . Carbon::parse($state)->diffForHumans() . ")"
                            : ($record->attendeCode()->end_date >= now() ? 'Belum Presensi' : 'Tidak Hadir')
                        )
                    ->color(fn (string $state): string => match ($state) {
                        'empty' => 'danger',
                        default => '',
                    })
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('attendeCode.id')
                    ->label('Attende Id')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('approvalStatus.name')
                    ->label('Approval Status')
                    ->searchable()
                    ->default('empty')
                    ->formatStateUsing(fn (string $state, Attende $record): string =>
                        $state != 'empty' ?
                            Carbon::parse($state)->format('d-m-Y H:i:s') . " (" . Carbon::parse($state)->diffForHumans() . ")"
                            : ($record->attendeCode->end_date >= now() ? 'Belum Presensi' : 'Tidak Hadir')
                        )
                    ->color(fn (string $state): string => match ($state) {
                        'Belum Presensi' => 'danger',
                        default => '',
                    })
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('attendeStatus.name')
                    ->label('Attendance Status')
                    ->searchable()
                    ->default('empty')
                    ->formatStateUsing(fn (string $state, Attende $record): string =>
                        $state != 'empty' ?
                            Carbon::parse($state)->format('d-m-Y H:i:s') . " (" . Carbon::parse($state)->diffForHumans() . ")"
                            : ($record->attendeCode->end_date >= now() ? 'Belum Presensi' : 'Tidak Hadir')
                        )
                    ->color(fn (string $state): string => match ($state) {
                        'Belum Presensi' => 'danger',
                        default => '',
                    })
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Photo')
                    ->searchable()
                    ->sortable()
                    ->visibility('private')
                    ->stacked()
                    ->wrap()
                    ->limit(5)
                    ->limitedRemainingText()
                    ->square()
                    ->extraImgAttributes(fn (Attende $record): array => [
                        'alt' => "{$record->name} image",
                    ])
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('latitude')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('longitude')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Filters\TernaryFilter::make('exist_attende')
                    ->label('Status Presensi')
                    ->placeholder('Semua')
                    ->trueLabel('Sudah Melakukan Presensi')
                    ->falseLabel('Belum Melakukan Presensi')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull(['attende_time', 'approval_status_id', 'attende_status_id']),
                        false: fn (Builder $query) => $query->whereNull(['attende_time', 'approval_status_id', 'attende_status_id']),
                        blank: fn (Builder $query) => $query,
                    )
                    ->columnSpanFull(),
                Tables\Filters\TrashedFilter::make()
                    ->columnSpanFull(),
                // filter by user
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->options(
                        fn (): array => \App\Models\User::pluck('name', 'id')->toArray(),
                    )
                    ->preload()
                    ->searchable()
                    ->placeholder('All Users')
                    ->columnSpanFull()
                    ->multiple(),
                Tables\Filters\Filter::make('created_at')
                    ->label('Created At')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until')
                            ->default(now()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['created_from'] ?? null) {
                            $indicators[] = Tables\Filters\Indicator::make('Created from ' . Carbon::parse($data['created_from'])->toFormattedDateString())
                                ->removeField('from');
                        }

                        if ($data['created_until'] ?? null) {
                            $indicators[] = Tables\Filters\Indicator::make('Created until ' . Carbon::parse($data['created_until'])->toFormattedDateString())
                                ->removeField('until');
                        }

                        return $indicators;
                    })
                    ->columnSpanFull(),
            ])
            ->actions([
                Tables\Actions\Action::make('Informasi')
                    ->modalContent(
                        fn (Attende $record): \Illuminate\Contracts\View\View => view(
                            'filament.admin.attende.info',
                            ['record' => $record],
                        )
                    )
                    ->hidden(fn (Attende $record): bool => $record->attende_time != null && $record->attende_status_id != null && $record->approval_status_id != null && $record->approval_status_id == 1)
                    ->icon('heroicon-o-information-circle')
                    ->color('info')
                    ->modalSubmitAction(false)
                    ->label('Info'),
                Tables\Actions\Action::make('Verifikasi')
                    ->form([
                        Forms\Components\Select::make('approval_status_id')
                            ->label('Approval Status For This Absence')
                            ->relationship('approvalStatus', 'name')
                            ->required()
                            ->placeholder('Select a approval status')
                            ->searchable()
                            ->preload()
                        // ->default(2) // default to approved disetujui
                    ])
                    ->visible(fn (Attende $record): bool => $record->attende_time != null && $record->attende_status_id != null && $record->approval_status_id != null && $record->approval_status_id == 1)
                    ->fillForm(fn (Attende $record): array => [
                        'approval_status_id' => $record->approval_status_id,
                    ])
                    ->slideOver()
                    ->modalWidth(\Filament\Support\Enums\MaxWidth::Medium)
                    ->action(function (array $data, Attende $record): void {
                        $record->update([
                            'approval_status_id' => $data['approval_status_id'],
                        ]);
                    })
                    ->modalSubmitActionLabel('Ya, Verifikasi')
                    ->color('success')
                    ->icon('heroicon-o-check-circle'),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('Reset')
                        ->visible(fn (Attende $record): bool => $record->attende_time != null && $record->attende_status_id != null && $record->approval_status_id != null && $record->approval_status_id == 1)
                        ->requiresConfirmation()
                        ->modalHeading('Reset Presensi Ini?')
                        ->modalDescription('Presensi ini akan direset dan statusnya akan menjadi belum presensi. Apakah anda yakin?')
                        ->modalSubmitActionLabel('Iya, Reset')
                        ->modalWidth(\Filament\Support\Enums\MaxWidth::Medium)
                        ->action(function (Attende $record): void {
                            $record->update([
                                'attende_time' => null,
                                'attende_status_id' => null,
                                'approval_status_id' => null,
                                'latitude' => null,
                                'longitude' => null,
                                'address' => null,
                                'photo' => '',
                            ]);

                            \Filament\Notifications\Notification::make()
                                ->title('Presensi Berhasil Direset, Silahkan Presensi Ulang')
                                ->success()
                                ->send();
                        })
                        ->modalSubmitActionLabel('Ya, Reset')
                        ->color('warning')
                        ->icon('heroicon-o-arrow-path'),
                    // Tables\Actions\DeleteAction::make(),
                ])
                    ->link()
                    ->label('Actions'),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                // Tables\Actions\DeleteBulkAction::make(),
                \AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction::make('Export Terpilih')
                    // ->withHiddenColumns()
                    ->formatStates([
                        'photo' => function (?\Illuminate\Database\Eloquent\Model $record) {
                            if ($record->photo == null) {
                                return '0 Foto';
                            }

                            return count($record->photo) . ' Foto';
                        },
                        'total_attende' => function (?\Illuminate\Database\Eloquent\Model $record) {
                            return Attende::where('user_id', $record->user_id)->count();
                        },
                    ])
                    ->extraViewData(fn (Attende $record) => [
                        'not_hadir' => $record->attendeCode->end_date >= now() ? true : false,
                    ]),
                Tables\Actions\RestoreBulkAction::make(),
                // ]),
            ])
            ->headerActions([
                \AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction::make('Export Semua')
                    // ->withHiddenColumns()
                    ->formatStates([
                        'photo' => function (?\Illuminate\Database\Eloquent\Model $record) {
                            if ($record->photo == null) {
                                return '0 Foto';
                            }

                            return count($record->photo) . ' Foto';
                        },
                    ])
                    ->color('info'),
            ]);
    }

    public static function getRelations(): array {
        return [
            //
        ];
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListAttendes::route('/'),
            'create' => Pages\CreateAttende::route('/create'),
            'view' => Pages\ViewAttende::route('/{record}'),
            'edit' => Pages\EditAttende::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string {
        return static::getModel()::count() > 10 ? 'warning' : 'primary';
    }

    public static function getEloquentQuery(): Builder {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
