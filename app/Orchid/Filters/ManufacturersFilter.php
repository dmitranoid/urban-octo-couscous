<?php

namespace App\Orchid\Filters;

use App\Models\Manufacturer;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class ManufacturersFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'manufacturer';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return [
            'manufacturer_id'
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
        return $builder->where('manufacturer_id', $this->request->get('manufacturer_id'));
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Select::make('manufacturer_id')
                ->options(Manufacturer::pluck( 'name', 'id'))
                ->empty()
                ->value($this->request->get('manufacturer_id'))
                ->title('Manufacturer'),
        ];
    }

    public function value(): string
    {
        return $this->name() . ': ' . Manufacturer::where('id', $this->request->get('manufacturer_id'))->first()->name;
    }
}