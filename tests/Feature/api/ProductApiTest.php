<?php

namespace Tests\Feature\api;

use App\Models\Product;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    public function testProductGetListResponseOk()
    {
        $response = $this->get('api/products');
        $response->assertStatus(200);
    }

    public function testProductsGetItemResponseOkAndDataValid()
    {
        $product = Product::firstWhere('is_active', 1);
        $response = $this->get('api/products/' . $product->id);
        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertEquals($product->id, $data['id']);
    }

    public function testProductsGetItemResponseOkAndDataValidMulti()
    {
        for ($i = 0; $i < 5; $i++) {
            $product = Product::inRandomOrder()->firstWhere('is_active', 1);
            $response = $this->get('api/products/' . $product->id);
            $response->assertStatus(200);
            $data = $response->json('data');
            $this->assertEquals($product->id, $data['id']);
        }
    }


    public function testProductsGetRelatedOkAndDataValid()
    {
        $product = Product::firstWhere('is_active', 1);
        $response = $this->get('api/products/' . $product->id . '/related');
        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertIsArray($data);
    }

}
