<?php

namespace App\Filament\Resources\BudgetResource\Pages;

use Filament\Actions;
use App\Models\Budget;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use App\Filament\Resources\BudgetResource;
use Filament\Resources\Pages\CreateRecord;


class CreateBudget extends CreateRecord
{
    protected static string $resource = BudgetResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $userId = Auth::id();
        $categoryId = $data['category_id'] ?? null;
        $month = $data['month'];
        $year = $data['year'];

        // Check for existing budget
        $existingBudget = Budget::where('user_id', $userId)
            ->where('category_id', $categoryId)
            ->where('month', $month)
            ->where('year', $year)
            ->exists();

        if ($existingBudget) {
            Notification::make()
                ->title('Duplicate Budget')
                ->body('A budget for this category (or general budget) already exists for the selected month and year.')
                ->danger()
                ->send();

            $this->halt(); // Stop the save process but keep the form open
        }

        // Ensure user_id is set to authenticated user
        $data['user_id'] = $userId;


        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return BudgetResource::getUrl('index');
    }
}
