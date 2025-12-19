<?php

namespace App\Orchid\Screens\Block;

use App\Models\Block;
use App\Models\Manufacturer;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class BlockEditScreen extends Screen
{

    /** @var Block $block */
    public $block;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Block $block): iterable
    {
        return [
            'block' => $block,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return ($this->block->exists ? 'Edit ' : 'Create ') . 'Content Block';
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
                ->confirm(__('Really delete block ?'))
                ->method('remove')
                ->canSee($this->block->exists() ?? false),

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
                Input::make('block.id')->title('id')->readonly(),
                Select::make('block.parent_id')
                    ->title('Block Page')
                    ->required()
                    ->fromModel(Page::class, 'name', 'id')
                    ->empty('Select Block Page')
                    ->disabled($this->block->exists),
                Input::make('block.name')->title('Content block name')->required(),
                Input::make('block.slug')->title('Slug')->help('autocreated when empty'),
                TextArea::make('block.content')->title('Content')->rows(5)->help('html tags allowed'),
                Input::make('block.position')->title('Position'),
                Switcher::make('block.is_active')->title('Active')->sendTrueOrFalse(),
                Matrix::make('block.params')
                    ->title('Additional Params')
                    ->help('params will be included in block API response as array')
                    ->columns([
                        'Param',
                        'Value',
                    ])
            ]),
        ];
    }

    public function save(Block $block, Request $request): RedirectResponse
    {
        $block->fill($request->collect('block')->toArray())
            ->save();

        return redirect()->route('platform.element.list');
    }

    public function remove(Block $block): RedirectResponse
    {
        if ($block->exists()) {

            $block->delete();

            // Toast::info(__('Content Block was removed'));
        } else {
            // Toast::info(__('Content Block not exists'));
        }

        return redirect()->route('platform.element.list');
    }


}