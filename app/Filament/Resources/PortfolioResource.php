<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PortfolioResource\Pages;
use App\Filament\Resources\PortfolioResource\RelationManagers;
use App\Models\Portfolio;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PortfolioResource extends Resource
{
    protected static ?string $model = Portfolio::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'Portfolio';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required(),
                Forms\Components\RichEditor::make('subtitle')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('scroll_text')
                    ->required(),
                Forms\Components\TextInput::make('bio_title')
                    ->required(),
                Forms\Components\RichEditor::make('bio_subtitle')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('skill_title')
                    ->required(),
                Forms\Components\RichEditor::make('quote')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('quote_author')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('contact_links_title')
                    ->required(),
                Forms\Components\Toggle::make('is_using_default_contact_links')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('scroll_text')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bio_title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('skill_title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact_links_title')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_using_default_contact_links')
                    ->boolean(),
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
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
                    ->link()
                    ->label('Actions'),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
                \AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction::make('Export Terpilih')
                // ]),
            ])
            ->headerActions([
                \AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction::make('Export Semua')
                    ->color('info'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePortfolios::route('/'),
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
}
