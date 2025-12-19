<?php

namespace App\Http\Controllers\api;

use App\Http\Resources\BlockResource;
use App\Models\Block;


class BlockController extends Controller
{
    public function bySlug($slug)
    {
        $element = Block::Active()->where('slug', $slug)
            ->first();
        if (!$element->exists()) {
            abort(404);
        }
        return BlockResource::make($element);
    }

    public function byPageAndSlug($page, $slug)
    {
        $element = Block::Active()->with('page')
            ->where('page.slug', $page)
            ->where('slug', $slug)
            ->first();
        if (!$element->exists()) {
            abort(404);
        }
        return BlockResource::make($element);
    }
}