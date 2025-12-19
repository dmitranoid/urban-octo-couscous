<?php

namespace Tests\Feature\api;

use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ManufacturerApiTest extends TestCase
{
    public function testManufacturerGetListResponseOk()
    {
        $response = $this->get('api/manufacturers');
        $response->assertStatus(200);
    }
    public function testManufacturerGetItemResponseOk()
    {
        $response = $this->get('api/manufacturers/1');
        $response->assertStatus(200);
    }

    public function testManufacturerPostItemResponse405()
    {
        $response = $this->post('api/manufacturers/', ['name'=>'test', 'image'=>'', 'slug'=>'']);
        $response->assertStatus(405);
    }

    public function testManufacturerGetTopResponse()
    {
        $response = $this->get('api/manufacturers/top');
        $response->assertStatus(200);
    }

    public function testManufacturerGetTopWithLimit()
    {
        $response = $this->get('api/manufacturers/top?limit=2');
        $response->assertStatus(200);
        $data = $response->json('data');
        self::assertCount(2, $data, 'returned items count wrong');

    }

    public function testManufacturerGetBySlugResponseOk()
    {
        $response = $this->get('api/manufacturers/byslug/siemens');
        $response->assertStatus(200);
        $data = $response->json('data');
        self::assertIsArray($data);
    }

    public function testManufacturerGetBySlugResponse404()
    {
        $response = $this->get('api/manufacturers/byslug/siemens-123567890');
        $response->assertStatus(404);
    }


}
