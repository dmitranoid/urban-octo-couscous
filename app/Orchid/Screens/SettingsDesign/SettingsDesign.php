<?php

namespace App\Orchid\Screens\SettingsDesign;

use App\Models\Manufacturer;
use App\Settings\GeneralDesignSettings;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\NoReturn;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class SettingsDesign extends Screen
{
    /** @var  GeneralDesignSettings */
    public $designSettings;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $this->designSettings = new GeneralDesignSettings();
        return [
            'settings' => [
                'title' => $this->designSettings->title,
                'email' => $this->designSettings->email,
                'phone' => $this->designSettings->phone,
                'address' => $this->designSettings->address,
                'mainMenuBrands' => $this->designSettings->mainMenuBrands,
                'mainMenuCatCount' => $this->designSettings->mainMenuCatCount,
            ]
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Site Design Settings';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('save')
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
                Input::make('settings.title')->title('Site Title'),
                Input::make('settings.phone')->title('Phone No'),
                Input::make('settings.email')->title('Email'),
                Input::make('settings.address')->title('Address'),
            ])->title('General'),
            Layout::rows([
                Select::make('settings.mainMenuBrands')
                    ->fromModel(Manufacturer::class, 'name')
                    ->title('Manufacturers')
                    ->multiple(),
                Input::make('settings.mainMenuCatCount')
                    ->type('number')
                    ->title('Categories count')
                    ->help('max categories count displayed for each manufacturer'),
            ])->title('Main Menu')
        ];
    }

    #[NoReturn] public function save(Request $request)
    {
        try {
            $settingsData = $request->get('settings');

            $designSettings = new GeneralDesignSettings();

            $designSettings->title = $settingsData['title'] ?? $designSettings->title;
            $designSettings->email = $settingsData['email'] ?? $designSettings->email;
            $designSettings->phone = $settingsData['phone'] ?? $designSettings->phone;
            $designSettings->address = $settingsData['address'] ?? $designSettings->address;
            $designSettings->mainMenuBrands = $settingsData['mainMenuBrands'];
            $designSettings->mainMenuCatCount = $settingsData['mainMenuCatCount'];
            $designSettings->save();
            Toast::success('settings saved');
        } catch (\Exception $e) {
            Toast::error('save settings error');
        }
    }
}