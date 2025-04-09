<?php

namespace App\Filament\Admin\Resources\CostSheetResource\Pages;

use App\Filament\Admin\Resources\CostSheetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCostSheets extends ListRecords
{
    protected static string $resource = CostSheetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
