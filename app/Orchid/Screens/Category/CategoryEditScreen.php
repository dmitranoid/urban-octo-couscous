<?php

namespace App\Orchid\Screens\Category;

use App\Models\Category;
use App\Models\Manufacturer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Psy\Util\Str;

class CategoryEditScreen extends Screen
{

    /** @var Category */
    public $category;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Category $category): iterable
    {
        return [
            'category' => $category,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return ($this->category->exists ? 'Edit ' : 'Create ') . 'category';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Remove'))
                ->icon('bs.trash3')
                ->confirm(__('Really delete Category ?'))
                ->method('remove')
                ->canSee($this->category->exists),

            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save'),
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
            Layout::rows(
                [
                    // Input::make('id')->disabled()->title('id'),
                    Relation::make('category.manufacturer_id')
                        ->title('Manufacturer')
                        ->fromModel(Manufacturer::class, 'name'),
                    Input::make('category.name')->title('Name'),
                    Input::make('category.slug')->title('Slug')->help('autogenerate if empty'),
                    Switcher::make('category.is_active')->title('Category is active')->sendTrueOrFalse(),
                    Quill::make('category.description')->title('Description'),
                    Picture::make('category.image')->title('Image'),
                ]
            )
        ];
    }

    public function save(Category $category, Request $request):RedirectResponse
    {
        $category->fill($request->collect('category')->toArray());
        if (empty($category->slug)) {
            $category->slug = \Illuminate\Support\Str::slug($category->name);
        }
        $category->save();
        return redirect()->route('platform.category.list');
    }

    public function remove(Category $category):RedirectResponse
    {
        $category->delete();
        return redirect()->route('platform.category.list');
    }
}