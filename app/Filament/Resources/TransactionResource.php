<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Transaction;
use Tables\Filters\DateFilter;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

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
                                    ->relationship('category', 'name')
                                    ->required(),
                                
                                Forms\Components\MarkdownEditor::make('description')
                                    ->columnSpan('full'),
                                
                                Forms\Components\TextInput::make('amount')
                                    ->numeric()
                                    ->prefix('$')
                                    ->maxValue(42949672.95)
                                    ->required(),

                                Forms\Components\DatePicker::make('date')
                                    ->default(now()),      
                    ])          

                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        $currentMonth = Carbon::today()->month; // June (6) for June 26, 2025
        $currentYear = Carbon::today()->year; // 2025

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'Expense' ? 'danger' : 'success'),
                Tables\Columns\TextColumn::make('amount')
                    ->money('USD')
                    ->formatStateUsing(function ($state, $record) {
                        return $record->category->type === 'Expense' ? 
                            '-$' . $state : 
                            '$' . $state;
                    })
                    ->color(function ($record) {
                        return $record->category->type === 'Expense' ? 'danger' : 'success';
                    }),
                
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->multiple()
                    ->preload(),


                Tables\Filters\Filter::make('Date')
                    ->form([
                        DatePicker::make('transaction_date')
                            ->label('Transaction Date')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['transaction_date'],
                                fn (Builder $query): Builder => $query->whereDate('date', $data['transaction_date']),
                            );
                    })
                    ->indicateUsing(function (array $data): ?string {
                        if (! $data['transaction_date']) {
                            return null;
                        }

                        return 'Created at ' . Carbon::parse($data['transaction_date'])->toFormattedDateString();
                    }),

                Tables\Filters\SelectFilter::make('date_period')
                    ->label('Date Period')
                    ->options([
                            'past_week' => 'Past Week',
                            'past_month' => 'Past Month',
                            'past_year' => 'Past Year',
                        ])
                    ->query(function ($query, array $data) {
                        if (empty($data['value'])) {
                            return;
                        }

                        $today = Carbon::today();

                        switch ($data['value']) {
                            case 'past_week':
                                $query->whereDate('date', '>=', now()->subWeek())
                                      ->whereDate('date', '<=', $today);
                                break;
                            case 'past_month':
                                $query->whereDate('date', '>=', now()->subMonth())
                                      ->whereDate('date', '<=', $today);
                                break;
                            case 'past_year':
                                $query->whereDate('date', '>=', now()->subYear())
                                      ->whereDate('date', '<=', $today);
                                break;
                        }
                    }),
                
                Tables\Filters\SelectFilter::make('month')
                    ->label('Month')
                    ->options(collect(range(1, 12))->mapWithKeys(fn ($m) => [$m => Carbon::create()->month($m)->format('F')]))
                    ->default($currentMonth) // Preselect current month (June)
                    ->query(function (Builder $query, array $data) use ($currentYear): Builder {
                        $month = $data['value'] ?? Carbon::today()->month;
                        if ($month === '') {
                            return $query; // No month filter for "All"
                        }
                        return $query->whereMonth('date', $month)
                                     ->whereYear('date', $currentYear);
                    })
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
