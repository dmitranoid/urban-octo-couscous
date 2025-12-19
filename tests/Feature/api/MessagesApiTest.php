<?php

namespace Tests\Feature\api;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MessagesApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testPostContactUs(): void
    {
        $data = [
            'author' => 'author-contact-us',
            'contact' => '+37529 111 111 11',
            'message' => 'message-test-contact-us'
        ];

        $response = $this->post('/api/messages/contact', $data);

        $response->assertStatus(201);

    }

    public function testPostQuestion(): void
    {
        $data = [
            'author' => 'author-question',
            'contact' => '+37529 111 111 11',
            'message' => 'question-test-text'
        ];

        $response = $this->post('/api/messages/question', $data);

        $response->assertStatus(201);

    }

    public function testPostPriceRequest(): void
    {
        $product = Product::first();
        $qty = random_int(10, 100);

        $data = [
            'author' => 'author-question',
            'contact' => '+37529 111 111 11',
            'qty' => $qty,
            'message' => 'product price request',
            'products' => ['id'=> $product->id, 'qty'=>$qty, 'price' => $product->price],
        ];

        $response = $this->post('/api/messages/pricerequest', $data);

        $response->assertStatus(201);

    }
}
