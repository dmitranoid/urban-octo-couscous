<?php

namespace App\Orchid\Filters;

use App\Orchid\OrchidHelper;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class StatusFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'status';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return [
            'status'
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
        return $builder->where('is_active', $this->request->get('status'));
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Select::make('status')
                ->empty()
                ->value($this->request->get('status'))
                ->options(OrchidHelper::statusTextArray())
                ->title('Active'),
        ];
    }

    public function value():string
    {
        return $this->name() . ': ' . OrchidHelper::statusTextArray()[$this->request->get('status')];
    }
}