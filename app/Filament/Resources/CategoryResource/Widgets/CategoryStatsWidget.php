<?php

namespace App\Filament\Resources\CategoryResource\Widgets;

use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class CategoryStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Categories', Category::count())
                ->description('All categories')
                ->color('primary'),
            Stat::make('Expense Categories', Category::where('type', 'expense')->count())
                ->description('Expense categories')
                ->color('danger'),
            Stat::make('Income Categories', Category::where('type', 'income')->count())
                ->description('Income categories')
                ->color('success'),
        ];
    }
}
