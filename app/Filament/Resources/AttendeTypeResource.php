<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendeTypeResource\Pages;
use App\Filament\Resources\AttendeTypeResource\RelationManagers;
use App\Models\AttendeType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendeTypeResource extends Resource
{
    protected static ?string $model = AttendeType::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Employee Management';

    protected static ?int $navigationSort = 4;
    protected static ?string $navigationLabel = 'Tipe Kehadiran';
    protected static ?string $modelLabel = 'Tipe Kehadiran';
    protected static ?string $pluralModelLabel = 'Tipe Kehadiran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->debounce(250)
                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', str()->slug($state))),
                Forms\Components\TextInput::make('slug')
                    // ->dehydrated()
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
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
                Tables\Filters\TrashedFilter::make(),
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
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Attende Type Deleted')
                                ->body('The attende type was deleted successfully.'),
                        ),
                ])
                    ->link()
                    ->label('Actions'),
                Tables\Actions\RestoreAction::make(),
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
            ]);
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
            'index' => Pages\ListAttendeTypes::route('/'),
            'create' => Pages\CreateAttendeType::route('/create'),
            'edit' => Pages\EditAttendeType::route('/{record}/edit'),
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

    public static function getEloquentQuery(): Builder {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
