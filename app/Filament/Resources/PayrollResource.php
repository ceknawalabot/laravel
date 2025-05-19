<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PayrollResource\Pages;
use App\Filament\Resources\PayrollResource\RelationManagers;
use App\Models\Payroll;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PayrollResource extends Resource
{
    protected static ?string $model = Payroll::class;

    protected static ?string $navigationLabel = 'Gaji';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('employee_id')
                    ->label('Karyawan')
                    ->relationship('employee', 'first_name')
                    ->required(),
                Forms\Components\DatePicker::make('pay_period_start')
                    ->label('Periode Gaji Mulai')
                    ->required(),
                Forms\Components\DatePicker::make('pay_period_end')
                    ->label('Periode Gaji Berakhir')
                    ->required(),
                Forms\Components\TextInput::make('salary')
                    ->label('Gaji')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('bonus')
                    ->label('Bonus')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('deductions')
                    ->label('Potongan')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('net_pay')
                    ->label('Gaji Bersih')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.first_name')->label('Karyawan')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('pay_period_start')->label('Periode Gaji Mulai')->date()->sortable(),
                Tables\Columns\TextColumn::make('pay_period_end')->label('Periode Gaji Berakhir')->date()->sortable(),
                Tables\Columns\TextColumn::make('salary')->label('Gaji')->sortable(),
                Tables\Columns\TextColumn::make('bonus')->label('Bonus')->sortable(),
                Tables\Columns\TextColumn::make('deductions')->label('Potongan')->sortable(),
                Tables\Columns\TextColumn::make('net_pay')->label('Gaji Bersih')->sortable(),
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
            'index' => Pages\ListPayrolls::route('/'),
            'create' => Pages\CreatePayroll::route('/create'),
            'edit' => Pages\EditPayroll::route('/{record}/edit'),
        ];
    }
}
