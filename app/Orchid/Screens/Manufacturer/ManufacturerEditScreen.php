<?php

namespace App\Orchid\Screens\Manufacturer;

use App\Models\Manufacturer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ManufacturerEditScreen extends Screen
{

    /** @var Manufacturer */
    public $manufacturer;


    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Manufacturer $manufacturer): iterable
    {
        return [
            'manufacturer' => $manufacturer
        ];
     }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {

        return ($this->manufacturer ? 'Edit ' : 'Create ') . 'manufacturer';
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
                ->confirm(__('Really delete Manufacturer ?'))
                ->method('remove')
                ->canSee($this->manufacturer->exists ?? false),

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
            Layout::rows([
                Input::make('manufacturer.name')->title('Name'),
                Input::make('manufacturer.slug')->title('Slug')->help('using for URL creation'),
                Input::make('manufacturer.position')->title('Position')->help('using for sorting'),

                Quill::make('manufacturer.description')->title('Description'),
                Picture::make('manufacturer.image')->title('Image'),
                CheckBox::make('manufacturer.is_active')->title('Active')->value(1),
            ])
        ];
    }

    public function save(Manufacturer $manufacturer, Request $request): RedirectResponse
    {
        $manufacturer
            ->fill($request->collect('manufacturer')->toArray());

        if (empty($manufacturer->slug)) {
            $manufacturer->slug = Str::slug($manufacturer->name);
        }

        $manufacturer
            ->save();

        return redirect()->route('platform.manufacturer.list');
    }

    public function remove(Manufacturer $manufacturer): RedirectResponse
    {
        if ($manufacturer->exists) {

            $manufacturer->delete();

            Toast::info(__('Manufacturer was removed'));
        } else {
            Toast::info(__('Manufacturer not exists'));
        }

        return redirect()->route('platform.manufacturer.list');
    }


}
