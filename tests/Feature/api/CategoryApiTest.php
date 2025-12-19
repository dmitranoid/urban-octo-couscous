<?php

namespace Tests\Feature\api;

use App\Models\Category;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class CategoryApiTest extends TestCase
{
    public function testCategoryGetListResponseOk()
    {
        $response = $this->get('api/categories');
        $response->assertStatus(200);
    }
    public function testCategoryGetItemResponseOk()
    {
        $response = $this->get('api/categories/1');
        $response->assertStatus(200);
    }

    public function testCategoryGetItemResponseNotFount()
    {
        $response = $this->get('api/categories/9999999999');
        $response->assertStatus(404);
    }

    public function testCategoryGetTopResponseOk()
    {
        $response = $this->get('api/categories/top');
        $response->assertStatus(200);
    }

    public function testCategoryGetByslugWithManufacturerResponseOk()
    {

        $category = Category::inRandomOrder()->with('manufacturer')->first();
        $response = $this->get('api/categories/byslug/' . $category->slug . '?manufacturer_id='.$category->manufacturer->id);
        $response->assertStatus(200);
        $this->assertEquals($response->json('data.id'), $category->id);
    }


}