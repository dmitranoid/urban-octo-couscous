<?php

namespace App\Http\Controllers\api;

use App\Http\Resources\ElementResource;
use App\Http\Resources\PageResource;
use App\Models\Element;
use App\Models\Page;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Element $page)
    {
        return PageResource::make($page);
    }

    public function bySlug($slug)
    {
        $page =  Page::Active()->where('slug', $slug)->first();
        if (!($page && $page?->exists())) {
            abort(404);
        }
        return PageResource::make($page);

    }

    public function blocks(string $slug)
    {
        $page =  Page::Active()->where('slug', $slug)->first();
        if (!$page?->exists()) {
            abort(404);
        }
        $elements = Element::Active()->where('parent_id', $page->id)->get();

        return ElementResource::collection($elements);
    }
}