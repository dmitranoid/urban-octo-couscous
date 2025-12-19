<?php

namespace App\Orchid\Screens\Message;

use App\Models\Message;
use App\Models\Product;
use Orchid\Icons\IconComponent;
use Orchid\Icons\IconFinder;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class MessageEditScreen extends Screen
{
    public $message;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Message $message): iterable
    {
        return [
            'message' => $message,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'View Message';
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
                ->confirm(__('Really delete Message ?'))
                ->method('remove'),

            Button::make(__('Mark as read'))
                ->icon('bs.check-circle')
                ->method('markRead'),
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
            Layout::legend('message', [
                Sight::make('created_at', 'Created At')->render(fn($item) => $item->created_at->format('Y-m-d H:i')),
                Sight::make('code', 'Code'),
                Sight::make('type', 'Type'),
                Sight::make('status', 'Status')->render(function ($item) {

                    switch ($item->status) {
                        case Message::STATUS_NEW :
                            $content = '<span class="badge bg-primary" >NEW</span>';
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
                Sight::make('author', 'Author Name'),
                Sight::make('contact', 'Contact'),
                Sight::make('message', 'Message Text'),
            ]),

        ];
    }

    public function markRead()
    {

        $this->message->status = Message::STATUS_READ;

        $this->message->save();

        return redirect()->route('platform.message.list');
    }

    public function remove(int $id)
    {
        $message = Message::find($id);

        $message->delete();

        Toast::info(__('Message was removed'));

        return redirect()->route('platform.message.list');
    }
}