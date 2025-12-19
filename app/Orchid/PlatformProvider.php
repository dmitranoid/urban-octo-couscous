<?php

declare(strict_types=1);

namespace App\Orchid;

use App\Models\Message;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Dashboard $dashboard
     *
     * @return void
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * Register the application menu.
     *
     * @return Menu[]
     */
    public function menu(): array
    {
        return [
// ************* Pages
            Menu::make('Dashboard')
                ->icon('bs.speedometer2')
                ->route('platform.dashboard'),
            Menu::make('Design')
                ->icon('bs.display')
                ->list([
                    Menu::make('Settings')
                        ->icon('bs.tv')
                        ->route('platform.settings.design'),

                    Menu::make('Pages')
                        ->icon('bs.card-heading')
                        ->route('platform.page.list'),

                    Menu::make('Page Blocks')
                        ->icon('bs.box-seam')
                        ->route('platform.element.list'),
                ]),

// ************* Products
            Menu::make('Catalog')
                ->icon('bs.tags')
                ->list([
                    Menu::make('Manufacturers')
                        ->icon('')
                        ->route('platform.manufacturer.list'),
                    Menu::make('Categories')
                        ->icon('')
                        ->route('platform.category.list'),

                    Menu::make('Products')
                        ->icon('')
                        ->route('platform.product.list'),

                    Menu::make('Import products...')
                        ->icon('bs.box-arrow-in-down')
                        ->route('platform.import.view'),
                ]),
            Menu::make('')
                ->divider(),

// ************* Orders
            Menu::make('Sales')
                ->icon('bs.cart')
                ->list([
//            Menu::make('Customers')
//                ->icon('bs.people')
//                ->route('platform.order.list'),

                    Menu::make('Orders')
                        ->icon('bs.bag')
                        ->route('platform.order.list')
                        ->badge(fn() => Message::orders()->where('status', Message::STATUS_NEW)->count()),

//            Menu::make('Baskets')
//                ->icon('bs.basket')
//                ->route('platform.basket.list'),
                    Menu::make('Messages')
                        ->icon('bs.chat-right-text')
                        ->route('platform.message.list')
                        ->badge(fn() => Message::informations()->where('status', Message::STATUS_NEW)->count()),
                ]),
            Menu::make('')
                ->divider(),


// ************* Users
            Menu::make('System')
                ->icon('bs.gear')
                ->list([
                    Menu::make(__('Users'))
                        ->icon('bs.people')
                        ->route('platform.systems.users'),
//                ->permission('platform.systems.users')
                    Menu::make(__('Roles'))
                        ->icon('bs.lock')
                        ->route('platform.systems.roles')
                        ->permission('platform.systems.roles')
                        ->divider(),
                ]),

// *************

//            Menu::make('Example Screen')
//                ->icon('bs.collection')
//                ->route('platform.example')
//                ->badge(fn() => 6),
//
//            Menu::make('Form Elements')
//                ->icon('bs.journal')
//                ->route('platform.example.fields')
//                ->active('*/form/examples/*'),
//
//            Menu::make('Overview Layouts')
//                ->icon('bs.columns-gap')
//                ->route('platform.example.layouts')
//                ->active('*/layout/examples/*'),
//
//            Menu::make('Charts')
//                ->icon('bs.bar-chart')
//                ->route('platform.example.charts'),
//
//            Menu::make('Cards')
//                ->icon('bs.card-text')
//                ->route('platform.example.cards')
//                ->divider(),


//            Menu::make('Documentation')
//                ->title('Docs')
//                ->icon('bs.box-arrow-up-right')
//                ->url('https://orchid.software/en/docs')
//                ->target('_blank'),
//
//            Menu::make('Changelog')
//                ->icon('bs.box-arrow-up-right')
//                ->url('https://github.com/orchidsoftware/platform/blob/master/CHANGELOG.md')
//                ->target('_blank')
//                ->badge(fn () => Dashboard::version(), Color::DARK),
        ];
    }

    /**
     * Register permissions for the application.
     *
     * @return ItemPermission[]
     */
    public function permissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
        ];
    }
}