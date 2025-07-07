<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\TransactionResource;
use Illuminate\Database\Eloquent\Builder;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make(),
            'Expenses' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('category', function ($query) {
                        $query->where('type', 'expense');
                    })
                ),
            'Income' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('category', function ($query) {
                        $query->where('type', 'income');
                    })
                ),
        ];
    }

    
}
