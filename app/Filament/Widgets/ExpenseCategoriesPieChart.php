<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class ExpenseCategoriesPieChart extends ChartWidget
{
    use InteractsWithPageFilters;
    
    protected static ?string $heading = 'Expense Categories';

    protected static ?int $sort = 4; // Widget order on dashboard

    protected function getType(): string
    {
        return 'pie';
    }

    protected function getData(): array
    {
        $selectedFilter = $this->filters['month'];
        
        $month = $selectedFilter ?? Carbon::today()->month; // Default to June 2025
        $year = Carbon::today()->year; // 2025

        // Define date range for the selected month
        $startOfMonth = $month ? Carbon::create($year, $month, 1)->startOfMonth() : null;
        $endOfMonth = $month ? $startOfMonth->copy()->endOfMonth() : null;

        // Query expenses by category
        $expenses = Transaction::whereHas('category', function ($query) {
            $query->where('type', 'expense');
        })
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->whereNotNull('date')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->groupBy('categories.id', 'categories.name')
            ->select(
                'categories.name',
                DB::raw('SUM(transactions.amount) as total')
            )
            ->orderBy('total', 'desc')
            ->get();

        // Prepare chart data
        $labels = $expenses->pluck('name')->toArray();
        $data = $expenses->pluck('total')->map(fn ($value) => (float) $value)->toArray();
        $colors = $this->generateColors(count($labels));

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Expenses by Category',
                    'data' => $data,
                    'backgroundColor' => $colors,
                    'borderColor' => $colors,
                    'borderWidth' => 1,
                ],
            ],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'right', // Place legend on the right
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(context) { 
                            const value = context.parsed;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return context.label + ": $" + value.toFixed(2) + " (" + percentage + "%)";
                        }',
                    ],
                ],
            ],
        ];
    }

    /**
     * Generate distinct colors for each category.
     *
     * @param int $count
     * @return array
     */
    protected function generateColors(int $count): array
    {
        $baseColors = [
            '#ef4444', // Red
            '#3b82f6', // Blue
            '#22c55e', // Green
            '#f59e0b', // Yellow
            '#a855f7', // Purple
            '#ec4899', // Pink
            '#14b8a6', // Teal
            '#f97316', // Orange
        ];

        $colors = [];
        for ($i = 0; $i < $count; $i++) {
            $colors[] = $baseColors[$i % count($baseColors)];
        }

        return $colors;
    }
}
