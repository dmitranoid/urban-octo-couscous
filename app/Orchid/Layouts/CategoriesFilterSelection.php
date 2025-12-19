<?php

namespace App\Orchid\Layouts;

use App\Orchid\Filters\ManufacturersFilter;
use App\Orchid\Filters\StatusFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class CategoriesFilterSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [
            ManufacturersFilter::class,
            StatusFilter::class
        ];
    }
}