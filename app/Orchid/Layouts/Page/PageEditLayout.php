<?php

namespace App\Orchid\Layouts\Page;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Layouts\Table;

class PageEditLayout extends Rows
{

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Input::make('page.id')->title('id')->readonly(),
            Input::make('page.name')->title('Page name')->required(),
            Input::make('page.slug')->title('Slug')->help('autocreated when empty'),
            TextArea::make('page.content')->title('Content')->help('html tags allowed'),
            Input::make('page.position')->title('Position'),
            Switcher::make('page.is_active')->title('Active')->sendTrueOrFalse(),
            Matrix::make('page.seo')->title('Page SEO attributes')
                ->columns([
                    'Attribute',
                    'Value',
                ]),

            Matrix::make('page.params')->title('Additional attributes')
                ->columns([
                    'Attribute',
                    'Value',
                ]),
        ];
    }
}