<?php

namespace App\Orchid\Layouts\Product;

use App\Models\Category;
use App\Models\Manufacturer;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Columns;
use Orchid\Support\Facades\Layout;

class ProductEditMainLayout extends Columns
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
            Layout::split([
                Layout::rows([
                    Input::make('product.id')->title('id')->readonly(true),
                    Relation::make('product.manufacturer_id')
                        ->title('Manufacturer')
                        ->fromModel(Manufacturer::class, 'name'),
                    Relation::make('product.category_id')
                        ->title('Category')
                        ->fromModel(Category::class, 'name'),
                    Input::make('product.sku')->title('SKU'),
                    Input::make('product.name')->title('Name'),
                    Switcher::make('product.is_active')->title('Active')->sendTrueOrFalse(),
                    Quill::make('product.description')->title('Description'),

                ]),
                Layout::rows([
                    Picture::make('product.image')->title('Main image')->targetRelativeUrl(),
                    Upload::make('product.attachment')
                        ->acceptedFiles('image/*,application/pdf,.psd,.zip,.rar,.7z')
                        ->targetRelativeUrl()
                        ->title('Documents'),
                ]),
            ]),
        ];
    }
}