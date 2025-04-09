<?php

namespace App\Filament\Admin\Resources\CostSheetResource\Pages;

use App\Filament\Admin\Resources\CostSheetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCostSheet extends EditRecord
{
    protected static string $resource = CostSheetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
