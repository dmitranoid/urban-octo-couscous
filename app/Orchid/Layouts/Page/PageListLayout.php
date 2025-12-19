<?php

namespace App\Orchid\Layouts\Page;

use App\Models\Page;
use App\Orchid\OrchidHelper;
use Illuminate\Support\Facades\Blade;
use Orchid\Icons\IconComponent;
use Orchid\Icons\IconFinder;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Toast;

class PageListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'pages';

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id')->sort(),
            TD::make('name')
                ->sort()->filter()
                ->render(fn($item)=>Link::make($item->name)->href(route('platform.page.edit', $item->id))),
            TD::make('slug')->sort()->filter(),
            TD::make('is_active', 'Active')
//                ->asComponent(IconComponent::class, ['path'=>'bs.check-circle'])
                ->sort()->filter()
                ->render(fn($item)=> OrchidHelper::renderBoolAsIcon($item->is_active)),
            TD::make(__('Actions'))
                ->align(TD::ALIGN_RIGHT)
                ->width('110px')
                ->render(fn(Page $item) => Group::make([
                    Link::make('')

                        ->route('platform.page.edit', $item->id)
                        ->icon('bs.pencil'),

                    Button::make('')
                        ->icon('bs.trash3')
                        ->confirm(__('Delete page ?'))
                        ->method('remove', [
                            'id' => $item->id,
                        ]),
                ])
                ),
        ];
    }

}