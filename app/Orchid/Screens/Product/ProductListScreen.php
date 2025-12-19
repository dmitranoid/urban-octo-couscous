<?php

namespace App\Orchid\Screens\Product;

use App\Models\Manufacturer;
use App\Models\Product;
use App\Orchid\Layouts\ProductsFilterSelection;
use App\Orchid\OrchidHelper;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ProductListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'products' => Product::with(['manufacturer', 'category'])
                ->filters(ProductsFilterSelection::class)
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
        return 'Products';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Create product'))
                ->icon('bs.plus-circle')
                ->route('platform.product.create'),
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
            ProductsFilterSelection::class,
            Layout::table('products',
                [
                    TD::make('id'),
                    TD::make('sku')
                        ->filter()
                        ->render(fn(Product $product) => Link::make($product->sku)->route('platform.product.edit', $product->id)),
                    TD::make('name')->filter(),
                    TD::make('image')
                        ->render(fn(Product $product) => $product->image ? sprintf('<img src="%s" style="width:50px;height:50px;object-fit:contain;"', $product->image) : ''),
                    TD::make('manufacturer.name', 'manufacturer'),
                    TD::make('category.name', 'category'),
                    TD::make('stock', 'Stock'),
                    TD::make('partner_stock', 'Stock (partners)'),
                    TD::make('is_active', 'active')
                        ->render(fn(Product $product) => OrchidHelper::renderBoolAsIcon($product->is_active == 1)),
                    TD::make(__('Actions'))
                        ->align(TD::ALIGN_RIGHT)
                        ->width('110px')
                        ->render(fn(Product $item) => Group::make([
                            Link::make('')

                                ->route('platform.product.edit', $item->id)
                                ->icon('bs.pencil'),

                            Button::make('')
                                ->icon('bs.trash3')
                                ->confirm(__('Delete product ?'))
                                ->method('remove', [
                                    'id' => $item->id,
                                ]),
                        ])
                        ),

                ])
        ];
    }

    public function remove(int $id)
    {
        $product = Product::find($id);

        if (!$product->exists) {
            Toast::error(__('Product not exists'));
            return redirect()->route('platform.product.list');
        }

        $product->delete();

        Toast::info(__('Product was removed'));

        return redirect()->route('platform.product.list');
    }
}