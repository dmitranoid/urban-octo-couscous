<?php

namespace App\Orchid\Layouts;

use App\Orchid\Filters\CategoriesFilter;
use App\Orchid\Filters\ManufacturersFilter;
use App\Orchid\Filters\OutOfStockFilter;
use App\Orchid\Filters\StatusFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class ProductsFilterSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [
            ManufacturersFilter::class,
            CategoriesFilter::class,
            StatusFilter::class,
            OutOfStockFilter::class,
        ];
    }
}