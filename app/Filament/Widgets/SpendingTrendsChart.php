<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use Flowframe\Trend\Trend;
use App\Models\Transaction;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class SpendingTrendsChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Spending Trends';

    protected static ?int $sort = 3; // Widget order on dashboard

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $selectedFilter = $this->filters['month'];
        
        $month = $selectedFilter ?? Carbon::today()->month; // Default to June 2025
        $year = Carbon::today()->year; // 2025

        // Define date range for the selected month
        $startOfMonth = $month ? Carbon::create($year, $month, 1)->startOfMonth() : null;
        $endOfMonth = $month ? $startOfMonth->copy()->endOfMonth() : null;

        // Use Trend to aggregate daily expenses
        $trend = Trend::query(
            Transaction::whereHas('category', function ($query) {
                $query->where('type', 'expense');
            })->whereNotNull('date')
        )
            ->between($startOfMonth, $endOfMonth)
            ->perDay()
            ->dateColumn('date')
            ->sum('amount');

        return [
            'labels' => $trend->map(fn (TrendValue $value) => $value->date)->toArray(),
            'datasets' => [
                [
                    'label' => 'Daily Expenses',
                    'data' => $trend->map(fn (TrendValue $value) => (float) $value->aggregate)->toArray(),
                    'borderColor' => '#ef4444', // Red for expenses
                    'backgroundColor' => 'rgba(239, 68, 68, 0.2)',
                    'fill' => true,
                    'tension' => 0.3, // Smooth line
                ],
            ],
        ];
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
                        'text' => 'Date',
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(context) { return context.dataset.label + ": $" + context.parsed.y.toFixed(2); }',
                    ],
                ],
            ],
        ];
    }
}
