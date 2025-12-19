<?php

namespace App\Orchid\Screens\Image;

use App\Models\Block;
use App\Models\Image;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ImageEditScreen extends Screen
{
    /** @var Image $image */
    public $image;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Image $image): iterable
    {
        return [
            'image' => $image,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->image->exists ? 'Edit ' : 'Create ' . 'Image Block';
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
                ->confirm(__('Really delete image block ?'))
                ->method('remove', ['id' => $this->image->id])
                ->canSee($this->image->exists),

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
                Input::make('image.id')->title('id')->readonly(),
                Select::make('image.parent_id')
                    ->title('Block Main Page')
                    ->required()
                    ->fromModel(Page::class, 'name', 'id')
                    ->empty('Select Page'),
//                    ->disabled(!empty($this->image->id)),
                Input::make('image.name')->title('Image title')->required(),
                Input::make('image.slug')->title('Slug')->help('autocreated when empty'),
                TextArea::make('image.content')->title('Content')->cols(5),
                Picture::make('image.image')->title('Image'),
                Input::make('image.position')->title('Position'),
                Switcher::make('image.is_active')->title('Active')->sendTrueOrFalse(),
                Matrix::make('image.params')
                    ->title('Additional Params')
                    ->help('params will be included in image API response as [params] array')
                    ->columns(['Param','Value'])
            ]),
        ];
    }


    public function save(Image $image, Request $request): RedirectResponse
    {
//        $block = Image::firstOrNew($request->collect('image')->get('id', null));
        $image
            ->fill($request->collect('image')->toArray())
            ->save();

        return redirect()->route('platform.element.list');
    }

    public function remove($id): RedirectResponse
    {
        $block = Image::find($id);

        if ($block->exists()) {

            $block->delete();

            Toast::info(__('Image Block was removed'));
        } else {
            Toast::info(__('Image Block not exists'));
        }

        return redirect()->route('platform.element.list');
    }
}