<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeaveRequestResource\Pages;
use App\Models\LeaveRequest;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LeaveRequestResource extends Resource
{
    protected static ?string $model = LeaveRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function getNavigationLabel(): string
    {
        return 'Permohonan Cuti';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('employee_id')
                    ->label('Nama')
                    ->relationship('employee', 'first_name')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $state) {
                        $employee = Employee::with(['department', 'position', 'store'])->find($state);
                        $set('department_name', $employee?->department?->name ?? '');
                        $set('position_title', $employee?->position?->title ?? '');
                        $set('active_membership_date', $employee?->active_membership_date ?? null);
                        // Clear store_id first to trigger reactive update
                        $set('store_id', null);
                        $set('store_id', $employee?->store?->id ?? null);
                    }),
                Forms\Components\TextInput::make('department_name')
                    ->label('Divisi')
                    ->disabled(),
                Forms\Components\TextInput::make('position_title')
                    ->label('Jabatan')
                    ->disabled(),
                Forms\Components\Select::make('store_id')
                    ->label('Toko')
                    ->relationship('store', 'name')
                    ->required(),
                Forms\Components\DatePicker::make('active_membership_date')
                    ->label('Tanggal Keanggotaan Aktif')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $state) {
                        $set('active_membership_date', $state);
                    }),
                Forms\Components\Select::make('contract_extension_status')
                    ->label('Status Perpanjang Kontrak')
                    ->options([
                        1 => 'Ya',
                        0 => 'Tidak',
                    ])
                    ->required(),
                Forms\Components\DatePicker::make('scheduled_return')
                    ->label('Jadwal Pulang'),
                Forms\Components\DatePicker::make('start_date')
                    ->label('Tanggal Mulai')
                    ->required(),
                Forms\Components\DatePicker::make('end_date')
                    ->label('Tanggal Selesai')
                    ->required(),
                Forms\Components\Select::make('type')
                    ->label('Tipe Cuti')
                    ->options([
                        'annual' => 'Tahunan',
                        'sick' => 'Sakit',
                        'unpaid' => 'Tanpa Bayar',
                    ])
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Menunggu',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.full_name')
                    ->label('Nama')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(fn ($record) => $record->employee->first_name . ' ' . $record->employee->last_name),
                Tables\Columns\TextColumn::make('employee.position.title')->label('Jabatan')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('employee.department.name')->label('Divisi')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('store.name')->label('Toko')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('active_membership_date')->label('Tanggal Keanggotaan Aktif')->date()->sortable(),
                Tables\Columns\TextColumn::make('contract_extension_status')
                    ->label('Status Perpanjang Kontrak')
                    ->formatStateUsing(fn ($state) => $state ? 'Ya' : 'Tidak')
                    ->sortable(),
                Tables\Columns\TextColumn::make('scheduled_return')->label('Jadwal Pulang')->date()->sortable(),
                Tables\Columns\TextColumn::make('start_date')->label('Tanggal Mulai')->date()->sortable(),
                Tables\Columns\TextColumn::make('end_date')->label('Tanggal Selesai')->date()->sortable(),
                Tables\Columns\TextColumn::make('type')->label('Tipe Cuti')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('status')->label('Status')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Ubah'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->label('Hapus'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeaveRequests::route('/'),
            'create' => Pages\CreateLeaveRequest::route('/create'),
            'edit' => Pages\EditLeaveRequest::route('/{record}/edit'),
        ];
    }
}