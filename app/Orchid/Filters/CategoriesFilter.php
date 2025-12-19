<?php

namespace App\Orchid\Filters;

use App\Models\Category;
use App\Models\Manufacturer;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class CategoriesFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'category';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return [
            'category_id',
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
        return $builder->where('category_id', $this->request->get('category_id'));
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Select::make('category_id')
                ->options(Category::pluck('name', 'id'))
                ->empty()
                ->value($this->request->get('category_id'))
                ->title('Category'),
        ];
    }

    public function value(): string
    {
        return $this->name() . ': ' . Category::where('id', $this->request->get('category_id'))->first()->name;
    }
}