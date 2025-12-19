<?php

namespace App\Orchid\Screens\Order;

use App\Models\Message;
use App\Models\Order;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class OrderListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return ['messages' => Message::orders()->filters()->defaultSort('created_at', 'desc')->paginate()];

    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Price Requests';
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
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('messages',
                [
                    TD::make('id', 'id')->defaultHidden(),
                    TD::make('created_at', 'Date')->filter()->sort()->alignRight()
                        ->render(
                            fn($item) => ($item->created_at ? $item->created_at->format('d-m-Y') : '-') . '<br>'
                                . ($item->created_at ? $item->created_at->format('H:i') : '')
                        ),
                    TD::make('code', 'Code')->filter()->sort(),
                    TD::make('type', 'Type')->filter()->sort(),
                    TD::make('author', 'Author')->filter()->sort(),
                    TD::make('message', 'Message')->render(fn($item) => Str::limit($item->message, 50)),
                    TD::make('status', 'Status')->render(function ($item) {
                        switch ($item->status) {
                            case Message::STATUS_NEW :
                                $content = '<span class="badge tr-bold order-status bg-primary">NEW</span>';
                                break;
                            case Message::STATUS_READ :
                                $content = '<span class="badge order-status bg-light">READ</span>';
                                break;
                            case Message::STATUS_ERROR:
                                $content = '<span class="badge order-status bg-warning">ERROR</span>';
                                break;
                            case Message::STATUS_MAILED :
                                $content = '<span class="badge order-status bg-success">MAILED</span>';
                                break;
                            default:
                        }
                        return $content;
                    }),
                    TD::make(__('Actions'))
                        ->align(TD::ALIGN_RIGHT)
                        ->width('110px')
                        ->render(fn(Message $item) => Group::make([
                            Link::make('')
                                ->route('platform.order.edit', $item->id)
                                ->icon('bs.eye'),
                            Button::make('')
                                ->icon('bs.trash3')
                                ->confirm(__('Remove price request ?'))
                                ->method('remove', [
                                    'id' => $item->id,
                                ]),
                        ])
                    ),
                ]
            )
        ];
    }


    public function remove(int $id)
    {
        $priceRequest = Message::find($id);

        $priceRequest->delete();

        Toast::info(__('Price request was removed'));

        return redirect()->route('platform.order.list');
    }
}