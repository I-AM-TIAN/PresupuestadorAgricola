<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Resources\CostSheetResource\Pages;
use App\Models\CostSheet;
use Filament\Resources\Resource;
use App\Filament\Admin\Resources\CostSheetResource\Pages\ListCostSheets;
use App\Filament\Admin\Resources\CostSheetResource\Pages\CreateCostSheet;
use App\Filament\Admin\Resources\CostSheetResource\Pages\EditCostSheet;
use App\Filament\Admin\Resources\CostSheetResource\Pages\ViewCostSheet;
use Filament\Tables;
use Filament\Forms;
use Filament\Tables\Columns\TextColumn;

class CostSheetResource extends Resource
{
    protected static ?string $model = CostSheet::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Hojas de costos';
    protected static ?string $pluralModelLabel = 'Hojas de costos';
    protected static ?string $modelLabel = 'Hoja de costos';

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Producto')->searchable()->sortable(),
                TextColumn::make('quantity')->label('Cantidad'),
                TextColumn::make('margin')->label('Margen (%)'),
                TextColumn::make('total_cost')
                    ->label('Costo total')
                    ->money('USD', true),
                TextColumn::make('unit_price')
                    ->label('Precio unitario')
                    ->money('USD', true),
                TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('d/m/Y H:i'),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        // Por ahora no editamos, solo visualizamos (o desactivamos más adelante)
        return $form->schema([]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListCostSheets::route('/'),
            'create' => CreateCostSheet::route('/create'),
            'edit'   => EditCostSheet::route('/{record}/edit'),
            'view'   => ViewCostSheet::route('/{record}'),
        ];
    }
}
