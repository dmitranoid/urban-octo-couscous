<?php

namespace App\Orchid\Screens\Order;

use App\Models\Message;
use App\Models\Product;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class OrderEditScreen extends Screen
{
    /** @var Message */
    public $message;

    public function query(Message $order): iterable
    {
        if ($paramsProducts = $order->params ?? []) {
            $productsList = Product::whereIn('sku', array_reduce($paramsProducts, function($acc, $item){$acc[] = $item['sku'] ?? ''; return $acc;}, []))
                ->with('category', 'manufacturer')
                ->get()
                ->toArray();
        } else {
            $productsList = [];
        }
        foreach ($productsList as &$product) {
            $paramItem = array_filter($paramsProducts, fn($v, $k)=> $v['sku'] = $product['sku'], ARRAY_FILTER_USE_BOTH);
            $product['qty'] = $paramItem ? ($paramItem[0]['qty'] ?? '0') : 0;
        }
        return [
            'message' => $order,
            'products' => $productsList,
        ];
    }

    public function name(): ?string
    {
        return 'View Price Request';
    }

    /**
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
                            $content = '<span class="order-status badge bg-primary" >NEW</span>';
                            break;
                        case Message::STATUS_READ :
                            $content = '<span class="order-status badge bg-light">READ</span>';
                            break;
                        case Message::STATUS_ERROR:
                            $content = '<span class="order-status badge bg-warning">ERROR</span>';
                            break;
                        case Message::STATUS_MAILED :
                            $content = '<span class="order-status badge bg-success">MAILED</span>';
                            break;
                        default:
                            $content='{undefined}';
                    }
                    return $content;
                }),
                Sight::make('author', 'Author Name'),
                Sight::make('contact', 'Contact'),
                Sight::make('message', 'Message Text'),
                Sight::make('', 'Ordered products')->render(fn()=>$this->getProductCards()),
            ]),

        ];
    }

    private function getProductCards()
    {
        $products = $this->query($this->message)['products'];
        $html = '<dl>';
        foreach ($products as $product) {
            $html .= <<<HTML
               <dt class="fw-normal w-75 float-start" >
                    <span class="fw-semibold">{$product['sku']}</span> {$product['name']}<br>
                    <span class="text-muted">{$product['manufacturer']['name']}/{$product['category']['name']}</span><br>
                    <span class="text-black">price: {$product['price']}</span>
               </dt> 
               <dd class="w-25 float-start">
                    qty: <span class="text-black fw-semibold">{$product['qty']}</span>
                </dd>
            HTML;
        }
//        foreach ($products as $product) {
//            $html .= <<<HTML
//            <div class="card p-3" style="width: 200px">
//                <a><img class="card-img-top" src="{$product['image']}"></a>
//                <h5 class="card-title"><a href="">{$product['sku']}</a></h5>
//                <p>
//                {$product['name']}<br>
//                {$product['manufacturer']['name']}/{$product['category']['name']}
//                </p>
//                <p class="d-block">price: {$product['price']}</p>
//                <p class="d-block fw-bold">qty: {$product['price']}</p>
//            </div>
//            HTML;
//        }
        $html .= '</dl>';
        return $html;
    }


    public function markRead()
    {
        try {
            $this->message->status = Message::STATUS_READ;
            $this->message->save();
        } catch (\Exception $e) {
            Toast::error('Message update error');
        }
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