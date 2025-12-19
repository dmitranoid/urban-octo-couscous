<?php

namespace Tests\Feature\api;

use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PageApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testGetPagesResponseOk(): void
    {
        $response = $this->get('api/pages/');
        $response->assertStatus(200);
    }

    public function testGetPageBySlugResponseOk(): void
    {
        $page = Page::all()->first();
        $response = $this->get('api/pages/' . $page->slug);
        $response->assertStatus(200);
    }

    public function testGetPageElementsResponseOk(): void
    {
        $page = Page::all()->first();
        $response = $this->get('api/pages/' . $page->slug . '/blocks');
        $response->assertStatus(200);
    }

}
