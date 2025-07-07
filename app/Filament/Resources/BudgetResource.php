<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Budget;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Transaction;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BudgetResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BudgetResource\RelationManagers;

class BudgetResource extends Resource
{
    protected static ?string $model = Budget::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationGroup = 'Finance-Management';
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Select::make('category_id')
                                    ->label('Category (Optional)')
                                    ->relationship('category', 'name')
                                    ->nullable()
                                    ->helperText('Leave blank for a total expense budget.'),
                                
                                Forms\Components\Select::make('month')
                                    ->options([
                                        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                                        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                                        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December',
                                    ])
                                    ->default(Carbon::today()->month)
                                    ->required(),

                                Forms\Components\TextInput::make('year')
                                    ->numeric()
                                    ->default(Carbon::today()->year)
                                    ->minValue(2000)
                                    ->maxValue(2100)
                                    ->required(),

                                Forms\Components\TextInput::make('amount')
                                    ->numeric()
                                    ->required()
                                    ->minValue(0.01),
                                                
                                
                    ])

                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category.name')
                    ->default('General')
                    ->searchable(query: fn ($query, $search) => $query->whereHas('category', fn ($q) => $q->where('name', 'like', "%{$search}%"))->orWhereNull('category_id')),
                    
                Tables\Columns\TextColumn::make('amount')
                    ->money('USD')
                    ->label('Budget Amount')
                    ->sortable(),

                Tables\Columns\TextColumn::make('spent')
                    ->money('USD')
                    ->label('Spent (June 2025)')
                    ->getStateUsing(function (Budget $record) {
                        $startDate = Carbon::create($record->year, $record->month, 1)->startOfMonth();
                        $endDate = Carbon::today(); // June 20, 2025
                        if ($record->category_id) {
                            return $record->category->transactions()
                                ->whereHas('category', fn ($query) => $query->where('type', 'expense'))
                                ->whereBetween('date', [$startDate, $endDate])
                                ->sum('amount');
                        } else {
                            return \App\Models\Transaction::whereHas('category', fn ($query) => $query->where('type', 'expense'))
                                ->whereBetween('date', [$startDate, $endDate])
                                ->sum('amount');
                        }
                    }),

                Tables\Columns\TextColumn::make('progress')
                    ->label('Progress')
                    ->getStateUsing(function (Budget $record) {
                        $startDate = Carbon::create($record->year, $record->month, 1)->startOfMonth();
                        $endDate = Carbon::today();
                        $spent = $record->category_id
                            ? $record->category->transactions()
                                ->whereHas('category', fn ($query) => $query->where('type', 'expense'))
                                ->whereBetween('date', [$startDate, $endDate])
                                ->sum('amount')
                            : \App\Models\Transaction::whereHas('category', fn ($query) => $query->where('type', 'expense'))
                                ->whereBetween('date', [$startDate, $endDate])
                                ->sum('amount');
                        return $record->amount > 0 ? round(($spent / $record->amount) * 100, 1) : 0;
                    })
                    ->suffix('%')
                    ->color(fn ($state) => $state >= 100 ? 'danger' : ($state >= 80 ? 'warning' : 'success')),

                Tables\Columns\TextColumn::make('month')
                    ->formatStateUsing(fn ($state) => date('F', mktime(0, 0, 0, $state, 1)))
                    ->sortable(),
                Tables\Columns\TextColumn::make('year')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options(\App\Models\Category::where('type', 'expense')->pluck('name', 'id')->toArray() + ['general' => 'General'])
                    ->query(function ($query, $state) {
                        if ($state['value'] === 'general') {
                            $query->whereNull('category_id');
                        } elseif ($state['value']) {
                            $query->where('category_id', $state['value']);
                        }
                    }),
                Tables\Filters\SelectFilter::make('month')
                    ->options(collect(range(1, 12))->mapWithKeys(fn ($m) => [$m => Carbon::create()->month($m)->format('F')]))
                    ->default(Carbon::today()->month), // June 2025
                Tables\Filters\SelectFilter::make('year')
                    ->options(collect(range(Carbon::today()->year - 5, Carbon::today()->year + 5))->mapWithKeys(fn ($y) => [$y => $y]))
                    ->default(Carbon::today()->year),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                ])->icon('heroicon-m-ellipsis-horizontal')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBudgets::route('/'),
            'create' => Pages\CreateBudget::route('/create'),
            'edit' => Pages\EditBudget::route('/{record}/edit'),
        ];
    }
}
