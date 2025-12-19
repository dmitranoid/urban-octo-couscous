<?php

namespace App\Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Switcher;

class OutOfStockFilter extends Filter
{

    const STOCK_STATUS = [
        'all' => 'all',
        'outstock' => 'only out of stock',
        'instock' => 'only in stock',
    ];

    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'stock';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return [
            'outofstock'
        ];
    }

    /**
     * Apply to a given Eloquent query builder.
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        switch ($this->request->get('outofstock')) {
            case 'outstock':
                return $builder->where('stock', 0);
            case 'instock':
                return $builder->where('stock', '>', 0);
            default:
                return $builder;
        }
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Select::make('outofstock')
                ->empty()
                ->value($this->request->get('outofstock'))
                ->options(self::STOCK_STATUS)
                ->title('Stock'),
        ];
    }

    public function value(): string
    {
        return $this->name() . ': ' . self::STOCK_STATUS[$this->request->get('outofstock')];
    }
}