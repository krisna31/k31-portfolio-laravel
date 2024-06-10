<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use DeepCopy\Filter\Filter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationGroup = 'Employee Management';

    protected static ?int $navigationSort = 10;
    protected static ?string $navigationLabel = 'Pegawai';
    protected static ?string $modelLabel = 'Pegawai';
    protected static ?string $pluralModelLabel = 'Pegawai';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required(fn(string $operation): bool => $operation === 'create'),
                Forms\Components\TextInput::make('name')
                    ->required(fn(string $operation): bool => $operation === 'create'),
                Forms\Components\Select::make('roles')
                    ->relationship('roles', 'name')
                    ->searchable()
                    ->multiple()
                    ->preload()
                    ->required(fn(string $operation): bool => $operation === 'create'),
                Forms\Components\Select::make('genders')
                    ->relationship('gender', 'name')
                    ->searchable()
                    ->preload()
                    ->required(fn(string $operation): bool => $operation === 'create'),
                    // ->createOptionForm(
                    //     fn(Form $form)
                    //     => GenderResource::form($form),
                    // )
                    // ->editOptionForm(
                    //     fn(Form $form)
                    //     => GenderResource::form($form),
                    // ),
                Forms\Components\Select::make('positions')
                    ->relationship('position', 'name')
                    ->searchable()
                    ->preload()
                    ->required(fn(string $operation): bool => $operation === 'create')
                    ->createOptionForm(
                        fn(Form $form)
                        => PositionResource::form($form),
                    )
                    ->editOptionForm(
                        fn(Form $form)
                        => PositionResource::form($form),
                    ),
                Forms\Components\DateTimePicker::make('birth_date')
                    ->required(fn(string $operation): bool => $operation === 'create'),
                Forms\Components\TextInput::make('nomor_induk_kependudukan')
                    ->required(fn(string $operation): bool => $operation === 'create'),
                Forms\Components\TextInput::make('nomor_induk_pegawai')
                    ->required(fn(string $operation): bool => $operation === 'create'),
                Forms\Components\TextInput::make('phone')
                    ->required(fn(string $operation): bool => $operation === 'create'),
                Forms\Components\Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->required(fn(string $operation): bool => $operation === 'create'),
                Forms\Components\DateTimePicker::make('email_verified_at'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn(string $state): string => bcrypt($state))
                    ->dehydrated(fn(?string $state): bool => filled($state))
                    ->required(fn(string $operation): bool => $operation === 'create'),
                Forms\Components\FileUpload::make('avatar_url')
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        null,
                        '4:3',
                        '1:1',
                    ])
                    ->imageEditorEmptyFillColor('#000000')
                    ->avatar()
                    ->imageEditor()
                    ->circleCropper()
                    ->openable()
                    ->minSize(512)
                    ->maxSize(1024),
            ]);
    }

    public static function table(Table $table): Table
    {
        function calculateTotalGaji(Forms\Set $set, Forms\Get $get, User $user)
        {
            // Assign the state to the month variable
            $month = "0{$get('bulan')}";

            // Get the year from the request
            $year = $get('tahun');

            // Get the attendance approval status from the request
            $statusKehadiran = $get('approval_status_id');

            $totalGaji = hitungGaji($user, $month, $year, $statusKehadiran);

            // Set the total salary in the response with idr format
            $set('total_gaji', $totalGaji);
        }

        function hitungGaji($user, $month, $year, $statusKehadiran)
        {
            // Count the number of attendances for the given month, year, and approval status
            $jumlahKehadiran = $user->attendes()
                ->whereMonth('attende_time', $month) // Filter by month
                ->whereYear('attende_time', $year) // Filter by year
                ->where('approval_status_id', $statusKehadiran) // Filter by approval status
                ->count(); // Count the number of records

            // Get the salary of the user's position
            $gajiKaraywan = $user->position->salary;

            // Calculate the total salary by multiplying the number of attendances by the salary
            $totalGaji = $jumlahKehadiran * $gajiKaraywan;

            return 'Rp. ' . number_format($totalGaji, 0, ',', '.');
        }

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->searchable()
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gender.name')
                    ->searchable()
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('position.name')
                    ->searchable()
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('position.department.name')
                    ->searchable()
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('birth_date')
                    ->dateTime('d-M-Y, h:m:i', 'Asia/Jakarta')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('theme')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('theme_color')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime('d-M-Y, h:m:i', 'Asia/Jakarta')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('provider')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('nomor_induk_kependudukan')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('nomor_induk_pegawai')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('phone')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ImageColumn::make('avatar_url')
                    ->circular()
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
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until')
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
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                    Tables\Actions\Action::make('Email Slip Gaji')
                        ->icon('heroicon-o-banknotes')
                        ->fillForm(fn(User $user): array => [
                            'nama' => $user->name,
                            'position' => $user->position->name,
                            'email' => $user->email,
                            'approval_status_id' => 2,
                            'bulan' => now()->subMonth()->month + 1,
                            'tahun' => date('Y'),
                            'total_gaji' => hitungGaji(
                                $user,
                                now()->subMonth()->month + 1,
                                date('Y'),
                                2
                            ),
                        ])
                        ->form([
                            Forms\Components\TextInput::make('nama')
                                ->label('Nama Karyawan')
                                ->disabled()
                                ->required(),
                            Forms\Components\TextInput::make('position')
                                ->label('Jabatan')
                                ->disabled()
                                ->required(),
                            Forms\Components\TextInput::make('email')
                                ->label('Email Karyawan')
                                ->disabled()
                                ->required(),
                            Forms\Components\Select::make('approval_status_id')
                                ->label('Untuk Tipe Persetujuan?')
                                ->options(
                                    \App\Models\ApprovalStatus::pluck('name', 'id')
                                )
                                ->afterStateUpdated(fn(Forms\Set $set, Forms\Get $get, User $user) => calculateTotalGaji($set, $get, $user))
                                ->live(debounce: 500)
                                ->native(false)
                                ->selectablePlaceholder(false)
                                ->required(),
                            Forms\Components\Select::make('bulan')
                                ->options(
                                    array_combine(
                                        range(1, 12),
                                        array_map(fn($month) => \Carbon\Carbon::create(null, $month)->format('F'), range(1, 12))
                                    ),
                                )
                                ->afterStateUpdated(fn(Forms\Set $set, Forms\Get $get, User $user) => calculateTotalGaji($set, $get, $user))
                                ->live(debounce: 500)
                                ->native(false)
                                ->selectablePlaceholder(false)
                                ->required(),
                            Forms\Components\Select::make('tahun')
                                ->options(
                                    array_combine(
                                        range(date('Y'), 2010),
                                        range(date('Y'), 2010),
                                    ),
                                )
                                ->afterStateUpdated(fn(Forms\Set $set, Forms\Get $get, User $user) => calculateTotalGaji($set, $get, $user))
                                ->live(debounce: 500)
                                ->native(false)
                                ->selectablePlaceholder(false)
                                ->required(),
                            Forms\Components\TextInput::make('total_gaji')
                                ->label('Total Gaji')
                                ->disabled()
                                ->live(onBlur: true)
                                ->required(),
                        ])
                        ->action(function (array $data, User $record): void {
                            $month = $data['bulan'];
                            $year = $data['tahun'];
                            $approvalId = $data['approval_status_id'];

                            $email = $record->email;

                            $totalGaji = hitungGaji($record, $month, $year, $approvalId);


                            try {
                                // send email to user email
                                Mail::to($email)->send(new \App\Mail\SlipGajiKaryawan($record, $data, $totalGaji));

                                // If the mail was sent successfully, send a success notification
                                \Filament\Notifications\Notification::make()
                                    ->title('Slip Gaji Berhasil Dikirim')
                                    ->success()
                                    ->icon('heroicon-o-envelope-open')
                                    ->send();
                            } catch (\Exception $e) {
                                // If the mail could not be sent, send a failure notification
                                \Filament\Notifications\Notification::make()
                                    ->title('Pengiriman Slip Gaji Gagal')
                                    ->color('danger')
                                    ->icon('heroicon-o-exclamation-circle')
                                    ->send();
                            }
                        })
                        ->requiresConfirmation()
                        ->modalHeading('Email Slip Gaji?')
                        ->modalDescription('Apakah Anda yakin ingin mengirimkan slip gaji ke email karyawan?')
                        ->modalSubmitActionLabel('Kirim Email')
                        ->modalIcon('heroicon-o-envelope'),
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
            ]);
    }

    public static function getPages(): array
    {
        return [
            // 'index' => Pages\ManageUsers::route('/'),
            'index' => Pages\ListUser::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
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
