<?php

namespace App\Orchid\Screens\Message;

use App\Models\Message;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class MessageListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return ['messages' => Message::informations()->filters()->defaultSort('created_at', 'desc')->paginate()];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Incoming Messages';
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
                    TD::make('created_at', 'Date')->filter()->sort()->alignRight()
                        ->render(
                            fn($item)=>($item->created_at ? $item->created_at->format('d-m-Y'): '-') . '<br>'
                            . ($item->created_at ? $item->created_at->format('H:i') : '')
                        ),
                    TD::make('code', 'Code')->filter()->sort(),
                    TD::make('type', 'Type')->filter()->sort(),
                    TD::make('author', 'Author')->filter()->sort(),
                    TD::make('message', 'Message')->render(fn($item)=>Str::limit($item->message, 50)),
                    TD::make('status', 'Status')->render(function ($item) {
                        switch ($item->status) {
                            case Message::STATUS_NEW :
                                $content = '<span class="badge tr-bold bg-primary" >NEW</span>';
                                break;
                            case Message::STATUS_READ :
                                $content = '<span class="badge bg-light">READ</span>';
                                break;
                            case Message::STATUS_ERROR:
                                $content = '<span class="badge bg-warning">ERROR</span>';
                                break;
                            case Message::STATUS_MAILED :
                                $content = '<span class="badge bg-success>MAILED</span>';
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
                                ->route('platform.message.edit', $item->id)
                                ->icon('bs.eye'),
                            Button::make('')
                                ->icon('bs.trash3')
                                ->confirm(__('Delete message ?'))
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
        $message = Message::find($id);

        $message->delete();

        Toast::info(__('Message was removed'));

        return redirect()->route('platform.message.list');
    }



}