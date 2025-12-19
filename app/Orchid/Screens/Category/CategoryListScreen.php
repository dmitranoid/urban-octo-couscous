<?php

namespace App\Orchid\Screens\Category;

use App\Models\Category;
use App\Models\Manufacturer;
use App\Orchid\Filters\CategoriesFilter;
use App\Orchid\Layouts\CategoriesFilterSelection;
use App\Orchid\OrchidHelper;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CategoryListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'categories' =>
                Category::with('manufacturer')
                    ->filters(CategoriesFilterSelection::class)
                    ->defaultSort('id')
                    ->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Product Categories';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Create category'))
                ->icon('bs.plus-circle')
                ->route('platform.category.create'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            CategoriesFilterSelection::class,
            Layout::table(
                'categories',
                [
                    TD::make('id'),
                    TD::make('manufacturer.name', 'Manufacturer'),
                    TD::make('name', 'Name')
                        ->sort()
                        ->render(
                            fn(Category $category) => Link::make($category->name)->route('platform.category.edit', $category->id)
                        )->filter(),
                    TD::make('image')->render(fn(Category $category) => $category->image ? sprintf('<img src="%s" style="width:50px;height:50px;object-fit:contain;"', $category->image) : ''),
                    TD::make('position', 'Position')
                        ->sort(),
                    TD::make('is_active', 'Active')
                        ->sort()
                        ->render(
                            fn(Category $category) => OrchidHelper::renderBoolAsIcon($category->is_active == 1)
                        ),
                    TD::make(__('Actions'))
                        ->align(TD::ALIGN_RIGHT)
                        ->width('110px')
                        ->render(fn(Category $category) => Group::make([
                            Link::make('')
                                ->route('platform.category.edit', $category->id)
                                ->icon('bs.pencil'),
                            Button::make('')
                                ->icon('bs.trash3')
                                ->confirm(__('Delete category ?'))
                                ->method('remove', [
                                    'id' => $category->id,
                                ]),
                        ])
                        ),

                ]
            ),
        ];
    }

    public function remove(Category $category)
    {
        $category->delete();

        Toast::info(__('Category was removed'));

        return redirect()->route('platform.category.list');
    }

}