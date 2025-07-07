<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use Flowframe\Trend\Trend;
use App\Models\Transaction;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverviewWidget extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 2;
    
    protected function getStats(): array
    {
        $selectedFilter = (int) $this->filters['month'];
        
        $month = $selectedFilter ?? Carbon::today()->month; // Default to June 2025
        $year = Carbon::today()->year; // 2025

        // Define date range for the selected month
        $startOfMonth = $month ? Carbon::create($year, $month, 1)->startOfMonth() : null;
        $endOfMonth = $month ? $startOfMonth->copy()->endOfMonth() : null;

        $totalExpenses = Transaction::whereHas('category', function ($query) {
            $query->where('type', 'expense');
        })
        ->whereBetween('date', [$startOfMonth, $endOfMonth])
        ->sum('amount');

        $totalIncome = Transaction::whereHas('category', function ($query) {
            $query->where('type', 'income');
        })
        ->whereBetween('date', [$startOfMonth, $endOfMonth])
        ->sum('amount');

        $totalBalance = $totalIncome - $totalExpenses;

        return [
            Stat::make('Total Expenses', number_format($totalExpenses, 2))
                ->description('Expenses for ' . (Carbon::create()->month($month)->monthName . ' ' . $year))
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('danger')
                ->chart($this->getExpenseChartData()),

            Stat::make('Total Income', number_format($totalIncome, 2))
                ->description('Income for ' . (Carbon::create()->month($month)->monthName . ' ' . $year))
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('success')
                ->chart($this->getIncomeChartData()),

             Stat::make('Monthly Balance', number_format($totalBalance, 2))
                ->description('Balance for ' . (Carbon::create()->month($month)->monthName . ' ' . $year))
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color($totalBalance >= 0 ? 'success' : 'danger')
                ->chart($this->getBalanceChartData()),
        ];
    }

    protected function getExpenseChartData(): array
    {
        $selectedFilter = (int) $this->filters['month'];
        
        $month = $selectedFilter ?? Carbon::today()->month; // Default to June 2025
        $year = Carbon::today()->year; // 2025

        // Define date range for the selected month
        $startOfMonth = $month ? Carbon::create($year, $month, 1)->startOfMonth() : null;
        $endOfMonth = $month ? $startOfMonth->copy()->endOfMonth() : null;

        $trend = Trend::query(
            Transaction::whereHas('category', function ($query) {
                $query->where('type', 'expense');
            })->whereNotNull('date')
        )
        ->between($startOfMonth, $endOfMonth)
        ->perDay()
        ->dateColumn('date')
        ->sum('amount');

        return $trend->map(fn (TrendValue $value) => $value->aggregate)->toArray();
    }

    protected function getIncomeChartData(): array
    {
       $selectedFilter = (int) $this->filters['month'];
        
        $month = $selectedFilter ?? Carbon::today()->month; // Default to June 2025
        $year = Carbon::today()->year; // 2025

        // Define date range for the selected month
        $startOfMonth = $month ? Carbon::create($year, $month, 1)->startOfMonth() : null;
        $endOfMonth = $month ? $startOfMonth->copy()->endOfMonth() : null;

        $trend = Trend::query(
            Transaction::whereHas('category', function ($query) {
                $query->where('type', 'income');
            })->whereNotNull('date')
        )
        ->between($startOfMonth, $endOfMonth)
        ->perDay()
        ->dateColumn('date')
        ->sum('amount');

        return $trend->map(fn (TrendValue $value) => $value->aggregate)->toArray();
    }

    protected function getBalanceChartData(): array
    {
        $selectedFilter = (int) $this->filters['month'];
        
        $month = $selectedFilter ?? Carbon::today()->month; // Default to June 2025
        $year = Carbon::today()->year; // 2025

        // Define date range for the selected month
        $startOfMonth = $month ? Carbon::create($year, $month, 1)->startOfMonth() : null;
        $endOfMonth = $month ? $startOfMonth->copy()->endOfMonth() : null;

        // Get daily income and expenses
        $incomeTrend = Trend::query(
            Transaction::whereHas('category', function ($query) {
                $query->where('type', 'income');
            })->whereNotNull('date')
        )
            ->between($startOfMonth, $endOfMonth)
            ->perDay()
            ->dateColumn('date')
            ->sum('amount');

        $expenseTrend = Trend::query(
            Transaction::whereHas('category', function ($query) {
                $query->where('type', 'expense');
            })->whereNotNull('date')
        )
            ->between($startOfMonth, $endOfMonth)
            ->perDay()
            ->dateColumn('date')
            ->sum('amount');

        // Calculate cumulative balance per day
        $dates = collect();
        $currentDate = $startOfMonth->copy();
        while ($currentDate->lte($endOfMonth)) {
            $dates->push($currentDate->format('Y-m-d'));
            $currentDate->addDay();
        }

        $incomeData = $incomeTrend->mapWithKeys(fn (TrendValue $value) => [$value->date => (float) $value->aggregate]);
        $expenseData = $expenseTrend->mapWithKeys(fn (TrendValue $value) => [$value->date => (float) $value->aggregate]);

        $cumulativeBalance = [];
        $runningTotal = 0;

        foreach ($dates as $date) {
            $dailyIncome = $incomeData->get($date, 0);
            $dailyExpense = $expenseData->get($date, 0);
            $runningTotal += ($dailyIncome - $dailyExpense);
            $cumulativeBalance[] = $runningTotal;
        }

        return $cumulativeBalance;
    }

    
}
