<?php

namespace App\Orchid\Screens\Product;

use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Orchid\Layouts\Product\ProductEditMainLayout;
use App\Orchid\Layouts\Product\ProductEditOptionsLayout;
use App\Orchid\Layouts\Product\ProductEditSeoLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Concerns\Makeable;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use PhpParser\Node\Stmt\Switch_;

class ProductEditScreen extends Screen
{

    /** @var Product */
    public $product;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Product $product): iterable
    {
        return [
            'product' => $product,
            'features' => $product->features,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return ($this->product ? 'Edit ' : 'Create ') . 'product';
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
                ->confirm(__('Really delete product ?'))
                ->method('remove'),

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
            Layout::tabs([
                'Main' => Layout::split([
                    Layout::rows([
                        Input::make('product.id')->title('id')->readonly(true),
                        Relation::make('product.manufacturer_id')
                            ->title('Manufacturer')
                            ->fromModel(Manufacturer::class, 'name'),
                        Relation::make('product.category_id')
                            ->title('Category')
                            ->fromModel(Category::class, 'name'),
                        Input::make('product.sku')->title('SKU'),
                        Input::make('product.name')->title('Name'),
                        Switcher::make('product.is_active')->title('Active')->sendTrueOrFalse(),
                        Quill::make('product.description')->title('Description'),

                    ]),
                    Layout::rows([
                        Picture::make('product.image')->title('Main image')->targetRelativeUrl(),
                        Upload::make('product.attachment')
                            ->acceptedFiles('image/*,application/pdf,.psd,.zip,.rar,.7z')
                            ->targetRelativeUrl()
                            ->title('Documents'),
                    ]),
                ]),
                'Options' => ProductEditOptionsLayout::class,
                'SEO' => ProductEditSeoLayout::class,
            ])
        ];
    }

    public function save(Product $product, Request $request): RedirectResponse
    {
        $product->fill($request->collect('product')->toArray());
        $changedFeatures = Product::getChangedFeatures($request->get('features'));
        // $product->options = $request->get('product')['options'] ?? [];
        $product->options = $changedFeatures;
        if (empty($product->slug)) {
            $product->slug = Str::slug($product->sku);
        }
        $product->save();
        $product->attachment('')->syncWithoutDetaching(
            $request->input('product.attachment', [])
        );

        return redirect()->route('platform.product.list');
    }

    public function remove(Product $product): RedirectResponse
    {
        if ($product->exists) {

            $product->delete();

            Toast::info(__('Product was removed'));
        } else {
            Toast::info(__('Product not exist'));
        }

        return redirect()->route('platform.product.list');
    }


}