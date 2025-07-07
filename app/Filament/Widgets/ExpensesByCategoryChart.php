<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;

class ExpensesByCategoryChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 3;
    
    protected static ?string $heading = 'Expenses By Categories';

    protected function getData(): array
    {
        // $startDate = Carbon::today()->startOfMonth(); // June 1, 2025
        // $endDate = Carbon::today(); // June 19, 2025

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
        
        // Generate distinct colors for each category
        $colors = $this->generateColors(count($labels));

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Expenses',
                    'data' => $data,
                    'backgroundColor' => $colors,
                    'borderColor' => $colors,
                    'borderWidth' => 1,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Amount ($)',
                    ],
                ],
                'x' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Category',
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => false, // Hide legend since we have one dataset
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(context) { return context.dataset.label + ": $" + context.parsed.y.toFixed(2); }',
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
