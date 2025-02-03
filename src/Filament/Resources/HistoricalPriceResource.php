<?php
declare(strict_types=1);

namespace Kkosmider\Omnibus\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Kkosmider\Omnibus\Filament\Resources\HistoricalPriceResource\Pages;
use Kkosmider\Omnibus\Models\HistoricalPrice;

class HistoricalPriceResource extends Resource
{
    protected static ?string $model = HistoricalPrice::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

    public static function getLabel(): ?string
    {
        return __('Historical Price');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Historical Prices');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Omnibus');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('priceable_id')
                    ->label(__('Priceable ID'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('priceable_type')
                    ->label(__('Priceable'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Product name'))
                    ->state(fn (HistoricalPrice $record): ?string => $record->priceable()
                        ->first()
                        ?->product()
                        ?->first()
                        ?->translateAttribute('name') ?? __('Unknown')
                    )
                    ->searchable(
                        query: fn (Builder $query, string $search): Builder =>
                            $query->whereHas(
                                'priceable.product',
                                function (Builder $query) use ($search): Builder {
                                    $locale = App::getLocale();

                                    return $query->whereRaw(
                                        "json_unquote(json_extract(attribute_data, ?)) like ?",
                                        ["$.name.value.$locale", "%$search%"]
                                    );
                            })
                    ),
                Tables\Columns\TextColumn::make('price')
                    ->label(__('Price recorded'))
                    ->formatStateUsing(fn (HistoricalPrice $record) => $record->price?->formatted())
                    ->searchable(),
                Tables\Columns\TextColumn::make('recorded_at')
                    ->dateTime()
                    ->sortable()
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageHistoricalPrice::route('/'),
        ];
    }
}
