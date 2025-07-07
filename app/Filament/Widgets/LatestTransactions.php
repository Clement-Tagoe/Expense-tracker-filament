<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\TransactionResource;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestTransactions extends BaseWidget
{
    protected static ?int $sort = 4;

    public function table(Table $table): Table
    {
        return $table
            ->query(TransactionResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('date', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('amount')
                    ->formatStateUsing(function ($state, $record) {
                        return $record->category->type === 'Expense'
                            ? '-$' . number_format($state, 2)
                            : '$' . number_format($state, 2);
                    })
                    ->color(function ($record) {
                        return $record->category->type === 'Expense' ? 'danger' : 'success';
                    }),

                Tables\Columns\TextColumn::make('date')
                    ->sortable(),
            ]);
    }
}
