<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationLabel(): string
    {
        return 'Karyawan';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('store_id')
                    ->label('Toko')
                    ->relationship('store', 'name')
                    ->nullable(),
                Forms\Components\TextInput::make('first_name')
                    ->label('Nama Depan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->label('Nama Belakang')
                    ->nullable()
                    ->maxLength(255),
                Forms\Components\TextInput::make('account_holder_name')
                    ->label('Nama Rekening')
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->label('Telepon')
                    ->tel()
                    ->maxLength(20),
                Forms\Components\Select::make('department_id')
                    ->label('Divisi')
                    ->relationship('department', 'name')
                    ->required(),
                Forms\Components\Select::make('position_id')
                    ->label('Jabatan')
                    ->relationship('position', 'title')
                    ->required(),
                Forms\Components\TextInput::make('bank')
                    ->label('Bank')
                    ->maxLength(255),
                Forms\Components\TextInput::make('account_number')
                    ->label('Nomor Rekening')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('active_membership_date')
                    ->label('Tanggal Keanggotaan Aktif')
                    ->format('d/m/Y')
                    ->displayFormat('d/m/Y'),
                Forms\Components\DatePicker::make('passport_expiry_date')
                    ->label('Expired Passport')
                    ->format('d/m/Y')
                    ->displayFormat('d/m/Y'),
                Forms\Components\DatePicker::make('visa_expiry_date')
                    ->label('Expired Visa')
                    ->format('d/m/Y')
                    ->displayFormat('d/m/Y'),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Aktif',
                        'inactive' => 'Tidak Aktif',
                        'terminated' => 'Berhenti',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')->label('Nama Depan')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('last_name')->label('Nama Belakang')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('account_holder_name')->label('Nama Rekening')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('phone')->label('Telepon')->sortable(),
                Tables\Columns\TextColumn::make('department.name')->label('Divisi')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('store.name')->label('Toko')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('position.title')->label('Jabatan')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('bank')->label('Bank')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('account_number')->label('Nomor Rekening')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('active_membership_date')->label('Tanggal Keanggotaan Aktif')->date('d/m/Y')->sortable(),
                Tables\Columns\TextColumn::make('passport_expiry_date')->label('Expired Passport')->date('d/m/Y')->sortable(),
                Tables\Columns\TextColumn::make('visa_expiry_date')->label('Expired Visa')->date('d/m/Y')->sortable(),
                Tables\Columns\TextColumn::make('status')->label('Status')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('store_id')
                    ->label('Toko')
                    ->relationship('store', 'name'),
                Tables\Filters\SelectFilter::make('department_id')
                    ->label('Divisi')
                    ->relationship('department', 'name'),
                Tables\Filters\SelectFilter::make('position_id')
                    ->label('Jabatan')
                    ->relationship('position', 'title'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Ubah'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Hapus'),
                ]),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
