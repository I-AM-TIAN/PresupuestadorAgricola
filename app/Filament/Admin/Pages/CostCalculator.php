<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;

class CostCalculator extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';
    protected static string $view = 'filament.admin.pages.cost-calculator';

    public ?array $formData = [];

    public function mount(): void
    {
        $this->form->fill($this->formData);
    }

    protected function getFormStatePath(): string
    {
        return 'formData';
    }

    protected function getFormSchema(): array
    {
        return [
            Wizard::make([
                // Paso 1 - Datos generales
                Step::make('Datos generales')
                    ->schema([
                        Forms\Components\TextInput::make('quantity')
                            ->label('Cantidad producida')
                            ->numeric()
                            ->minValue(1)
                            ->required(),

                        Forms\Components\TextInput::make('margin')
                            ->label('Margen de ganancia (%)')
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                    ])
                    ->columns(2),

                // Paso 2 - Materiales
                Step::make('Materiales')
                    ->schema([
                        Forms\Components\Repeater::make('materials')
                            ->addActionLabel('Agregar material')
                            ->grid(false)
                            ->columns(12)
                            ->schema([
                                Forms\Components\TextInput::make('description')
                                    ->label('Descripción')
                                    ->columnSpan(8),
                                Forms\Components\TextInput::make('cost')
                                    ->label('Costo')
                                    ->numeric()
                                    ->prefix('$')
                                    ->minValue(0)
                                    ->default(0)
                                    ->columnSpan(4),
                            ])
                            ->default([
                                ['description' => '', 'cost' => 0],
                            ])
                            ->itemLabel(fn ($state) => $state['description'] ?? 'Material'),
                    ]),

                // Paso 3 - Mano de obra
                Step::make('Mano de obra')
                    ->schema([
                        Forms\Components\Repeater::make('labor')
                            ->addActionLabel('Agregar mano de obra')
                            ->grid(false)
                            ->columns(12)
                            ->schema([
                                Forms\Components\TextInput::make('description')
                                    ->label('Descripción')
                                    ->columnSpan(8),
                                Forms\Components\TextInput::make('cost')
                                    ->label('Costo')
                                    ->numeric()
                                    ->prefix('$')
                                    ->minValue(0)
                                    ->default(0)
                                    ->columnSpan(4),
                            ])
                            ->default([
                                ['description' => '', 'cost' => 0],
                            ])
                            ->itemLabel(fn ($state) => $state['description'] ?? 'Mano de obra'),
                    ]),

                // Paso 4 - Costos indirectos
                Step::make('Costos indirectos')
                    ->schema([
                        Forms\Components\Repeater::make('indirect')
                            ->addActionLabel('Agregar costo indirecto')
                            ->grid(false)
                            ->columns(12)
                            ->schema([
                                Forms\Components\TextInput::make('description')
                                    ->label('Descripción')
                                    ->columnSpan(8),
                                Forms\Components\TextInput::make('cost')
                                    ->label('Costo')
                                    ->numeric()
                                    ->prefix('$')
                                    ->minValue(0)
                                    ->default(0)
                                    ->columnSpan(4),
                            ])
                            ->default([
                                ['description' => '', 'cost' => 0],
                            ])
                            ->itemLabel(fn ($state) => $state['description'] ?? 'Indirecto'),
                    ]),

                // Paso 5 - Resumen
                Step::make('Resumen final')
                    ->schema([
                        Forms\Components\Placeholder::make('Resumen')
                            ->content(function () {
                                return view('filament.admin.pages.summary', [
                                    'quantity'    => $this->formData['quantity'] ?? 0,
                                    'margin'      => $this->formData['margin'] ?? 0,
                                    'materials'   => $this->getCategoryTotal('materials'),
                                    'labor'       => $this->getCategoryTotal('labor'),
                                    'indirect'    => $this->getCategoryTotal('indirect'),
                                    'total'       => $this->getTotalCost(),
                                    'unitPrice'   => $this->getUnitPrice(),
                                ])->render();
                            }),
                    ]),
                ]),
        ];
    }

    public function getCategoryTotal(string $key): float
    {
        return collect($this->formData[$key] ?? [])
            ->sum(fn ($item) => floatval($item['cost'] ?? 0));
    }

    public function getTotalCost(): float
    {
        return $this->getCategoryTotal('materials')
             + $this->getCategoryTotal('labor')
             + $this->getCategoryTotal('indirect');
    }

    public function getUnitPrice(): float
    {
        $quantity = intval($this->formData['quantity'] ?? 0);
        if ($quantity <= 0) return 0;

        $base = $this->getTotalCost() / $quantity;
        $margin = floatval($this->formData['margin'] ?? 0);

        return $base * (1 + $margin / 100);
    }
}
