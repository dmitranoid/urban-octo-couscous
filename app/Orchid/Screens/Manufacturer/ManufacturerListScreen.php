<?php

namespace App\Orchid\Screens\Manufacturer;

use App\Models\Manufacturer;
use App\Orchid\OrchidHelper;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Repository;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ManufacturerListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'manufacturers' => Manufacturer::filters()->defaultSort('id')->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Manufacturers list';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Create manufacturer'))
                ->icon('bs.plus-circle')
                ->route('platform.manufacturer.create'),
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
            Layout::table(
                'manufacturers',
                [
                    TD::make('id')
                        ->sort(),
                    TD::make('name', 'Name')->render(
                        fn(Manufacturer $manufacturer) => Link::make($manufacturer->name)
                            ->route('platform.manufacturer.edit', $manufacturer->id)
                    )->filter()
                        ->sort(),
                    TD::make('image', 'Image')
                        ->render(function (Manufacturer $item) {
                            $img = $item->image;
                            return $img ? sprintf('<img src="%s" style="width:50px;height:50px;object-fit:contain;"', $img) : '';
                        }),
                    TD::make('position', 'Position')->sort(),
                    TD::make('is_active', 'Active')
                        ->sort()
                        ->filter()
                        ->render(fn(Manufacturer $manufacturer) => OrchidHelper::renderBoolAsIcon($manufacturer->is_active == 1)),
                    TD::make(__('Actions'))
                        ->align(TD::ALIGN_RIGHT)
                        ->width('110px')
                        ->render(fn(Manufacturer $manufacturer) => Group::make([
                            Link::make('')
                                ->route('platform.manufacturer.edit', $manufacturer->id)
                                ->icon('bs.pencil'),
                            Button::make('')
                                ->icon('bs.trash3')
                                ->confirm(__('Delete manufacturer ?'))
                                ->method('remove', [
                                    'id' => $manufacturer->id,
                                ]),
                        ]),
                        ),
                ]
            )
        ];

    }


    public function remove(int $id)
    {
        $manufacturer = Manufacturer::find($id);

        $manufacturer->delete();

        Toast::info(__('Manufacturer was removed'));

        return redirect()->route('platform.manufacturer.list');
    }

}