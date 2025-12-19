<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Message;
use App\Models\Product;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class DashboardScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'metrics' => [
                'manufacturers' => Manufacturer::all()->count(),
                'categories' => Category::all()->count(),
                'products' => Product::all()->count(),
                'orders' => [
                    'value' => Message::orders()->count(),
                    'new' => Message::orders()->where('status', Message::STATUS_NEW)->count(),
                ],
                'messages' => [
                    'value' => Message::informations()->count(),
                    'new' => Message::informations()->where('status', Message::STATUS_NEW)->count(),
                ],
            ],
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Site Dashboard';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Welcome to your site dashboard.';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::metrics([
                'Manufacturers'    => 'metrics.manufacturers',
                'Categories' => 'metrics.categories',
                'Products' => 'metrics.products',
            ])->title('Catalog'),
            Layout::metrics([
                'New Orders' => 'metrics.orders',
                'New Messages' => 'metrics.messages',
            ])->title('Messages'),

        ];
    }
}