<?php

namespace App\Http\Controllers\api;

use App\Http\Resources\ImageResource;
use App\Models\Image;

class ImageController extends Controller
{
    public function bySlug($slug)
    {
        $element = Image::Active()->where('slug', $slug)
            ->first();
        if (!$element->exists()) {
            abort(404);
        }
        return ImageResource::make($element);

    }

    public function byPageAndSlug($page, $slug)
    {
        $element = Image::Active()->whith('page')
            ->where('page.slug', $page)
            ->where('slug', $slug)
            ->first();
        if (!$element->exists()) {
            abort(404);
        }
        return ImageResource::make($page);
    }

}