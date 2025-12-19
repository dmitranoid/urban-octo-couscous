<?php

namespace App\Orchid\Screens\Element;

use App\Models\Element;
use App\Orchid\OrchidHelper;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ElementListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'elements' => Element::OnlyElements()->with('page')->get(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Page Blocks List';
    }

    public function description(): ?string
    {
        return 'Here you can manage static blocks, using in your pages';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Content block')
                ->icon('bs.plus-circle')
                ->href(route('platform.block.create')),
            Link::make('Image Block')
                ->icon('bs.plus-circle')
                ->href(route('platform.image.create')),
            Link::make('Image List')
                ->icon('bs.plus-circle')
                ->href(route('platform.imagelist.create')),

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
            Layout::table('elements', [
                TD::make('page.name', 'Page')
                    ->filter()
                    ->sort()
                    ->render(fn($item) => Link::make($item->page?->name)->href(route('platform.page.edit', $item->parent_id))),
                TD::make('name', 'Name')
                    ->sort()->filter()
                    ->render(function ($item) {
                        $href = '#';
                        switch ($item->type) {
                            case Element::ELEMENT_BLOCK :
                                $href = route('platform.block.edit', $item->id);
                                break;
                            case Element::ELEMENT_IMAGE:
                                $href = route('platform.image.edit', $item->id);
                                break;
                            case Element::ELEMENT_IMAGES:
                                $href = route('platform.images.edit', $item->id);
                                break;
                        }
                        return Link::make($item->name)->href($href);
                    }),
                TD::make('slug', 'Slug')->sort()->filter(),
                TD::make('type', 'Type')->sort()->filter(),
                TD::make('is_active', 'Active')->sort()->filter()
                    ->render(fn($item) => OrchidHelper::renderBoolAsIcon($item->is_active == 1)),
                TD::make(__('Actions'))
                    ->align(TD::ALIGN_RIGHT)
                    ->width('110px')
                    ->render(function (Element $element) {
                        $href = '#';
                        switch ($element->type) {
                            case Element::ELEMENT_BLOCK :
                                $href = route('platform.block.edit', $element->id);
                                break;
                            case Element::ELEMENT_IMAGE:
                                $href = route('platform.image.edit', $element->id);
                                break;
                            case Element::ELEMENT_IMAGES:
                                $href = route('platform.images.edit', $element->id);
                                break;
                        }
                        return Group::make([
                        Link::make('')
                            ->href($href)
                            ->icon('bs.pencil'),
                        Button::make('')
                            ->icon('bs.trash3')
                            ->confirm(__('Delete Page Element ?'))
                            ->method('remove', [
                                'id' => $element->id,
                            ]),
                    ]);
                    }),
            ]),
        ];
    }



    public function remove(int $id)
    {
        $element = Element::find($id);

        $element->delete();

        Toast::info(__('Element was removed'));

        return redirect()->route('platform.element.list');
    }
}