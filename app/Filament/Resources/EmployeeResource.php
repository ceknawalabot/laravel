<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                Forms\Components\TextInput::make('first_name')
                    ->label('Nama Depan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->label('Nama Belakang')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
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
                Forms\Components\DatePicker::make('date_of_birth')
                    ->label('Tanggal Lahir'),
                Forms\Components\DatePicker::make('date_of_hire')
                    ->label('Tanggal Masuk'),
                Forms\Components\Textarea::make('address')
                    ->label('Alamat'),
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
                Tables\Columns\TextColumn::make('email')->label('Email')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('phone')->label('Telepon')->sortable(),
                Tables\Columns\TextColumn::make('department.name')->label('Divisi')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('position.title')->label('Jabatan')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('date_of_birth')->label('Tanggal Lahir')->date()->sortable(),
                Tables\Columns\TextColumn::make('date_of_hire')->label('Tanggal Masuk')->date()->sortable(),
                Tables\Columns\TextColumn::make('status')->label('Status')->sortable(),
            ])
            ->filters([
                //
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
