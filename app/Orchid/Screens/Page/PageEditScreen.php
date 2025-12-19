<?php

namespace App\Orchid\Screens\Page;

use App\Models\Element;
use App\Models\Page;
use App\Orchid\Layouts\Page\PageEditLayout;
use App\Orchid\OrchidHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PageEditScreen extends Screen
{

    /** @var Page $page */
    public $page;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Page $page): iterable
    {
        return [
            'page' => $page,
            'elements' => $page->elements,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return ($this->page?->id ? 'Edit ' : 'Create ') . 'Page';
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Remove'))
                ->icon('bs.trash3')
                ->confirm(__('Really remove page ?'))
                ->method('remove')
                ->canSee($this->page?->exists() ?? true),

            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return Layout[]|string[]
     */
    public function layout(): iterable
    {
        return array(
            Layout::modal('editElement', [
                Layout::rows([
                    Input::make('element.id')->hidden(),
                    Input::make('element.name')->title('Title'),
                    Input::make('element.slug')->title('Slug'),
                    Switcher::make('element.is_active')->title('Active')->sendTrueOrFalse(),
                    TextArea::make('element.content')->title('Content')->rows(10),
                    Picture::make('element.image')->title('Image'),
                    Matrix::make('element.params')
                        ->columns(['Param','Value'])
                        ->title('Additional Params')
                        ->help('params will be included in image API response as [params] array')
                ]),
            ])
                ->title('Page block')
                ->applyButton('Save')
                ->closeButton('Close')
                ->async('asyncLoadElement')
                ->size(Modal::SIZE_LG),
            Layout::tabs([
                'Page Information' => [PageEditLayout::class],
                'Page Blocks' => [Layout::table(
                    'elements',
                    [
                        TD::make('slug', 'Slug')
                            ->render(function ($item) {
                                return
                                    ModalToggle::make($item->slug)
                                        ->modal('editElement')
                                        ->method('updateElement')
                                        ->asyncParameters(['id' => $item->id]);
                            }),
                        TD::make('name', 'Name'),
                        TD::make('type', 'Type'),
                        TD::make('is_active', 'Active')
                            ->render(fn($item) => OrchidHelper::renderBoolAsIcon($item->is_active)),
                        TD::make('', 'Actions')
                            ->render(function ($item) {
                                return
                                    ModalToggle::make('Edit')
                                        ->icon('bs.pencil')
                                        ->modal('editElement')
                                        ->method('updateElement')
                                        ->asyncParameters(['id' => $item->id]);
                            }),
                    ]
                )]

            ])
        );
    }

    public function save(Page $page, Request $request): RedirectResponse
    {
        $page->fill($request->collect('page')->toArray())
            ->save();
        return \redirect()->route('platform.page.list');
    }

    public function remove(Page $page, Request $request): RedirectResponse
    {
        $page->delete();
        return \redirect()->route('platform.page.list');
    }

    public function asyncLoadElement(int $id): iterable
    {
        return [
            'element' => Element::find($id),
        ];
    }

    public function updateElement(Request $request):void
    {
        //dd($request);
        $elementData = $request->collect('element');
        $element = Element::find($elementData['id']);
        if($element) {
            if ($element->update($elementData->toArray())) {
                Toast::success('Element updated');
            } else {
                Toast::error('Update failed');
            }
        } else {
            Toast::error('Update failed, element not found');
        }
    }
}