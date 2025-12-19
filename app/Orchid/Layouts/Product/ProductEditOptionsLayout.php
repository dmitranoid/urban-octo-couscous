<?php

namespace App\Orchid\Layouts\Product;

use App\Models\Product;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Layouts\Rows;

class ProductEditOptionsLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Group::make([
                Input::make('product.price')->title('Price'),
                Input::make('product.stock')->title('In stock'),
                Input::make('product.partner_stock')->title('In stock (partners)'),
            ]),
            Matrix::make('features')->title('Product features')
                ->columns(['slug', 'title', 'isActive'])
                ->maxRows(count(Product::getDefaultFeatures()))
                ->fields([
                    'slug' => Input::make('slug'),
                    'title' => Input::make('title'),
                    'isActive' => Switcher::make('isActive')->sendTrueOrFalse(),
                ]),
            // Matrix::make('product.options')->title('Custom params'),
        ];
    }
}