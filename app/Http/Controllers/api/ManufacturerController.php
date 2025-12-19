<?php

namespace App\Http\Controllers\api;

use App\Http\Resources\ManufactureResource;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Settings\GeneralDesignSettings;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Config;

class ManufacturerController extends Controller
{
    public function index()
    {
        return ManufactureResource::collection(Manufacturer::Active()
            ->orderBy(\request('order', 'position'), \request('direction', 'asc'))
            ->paginate(\request()->get('limit', 1000))
        );
    }

    public function top()
    {
        return ManufactureResource::collection(
            Manufacturer::Active()
                ->limit(\request()->get('limit', Config::get('app.limit')))
                ->orderBy(\request('order', 'position'), \request('direction', 'asc'))
            ->get()
        );
    }

    public function show(Manufacturer $manufacturer)
    {
       return new ManufactureResource($manufacturer);
    }

    public function bySlug(string $slug)
    {
        $manufacturer = Manufacturer::Active()->where('slug', $slug)->first();
        if (!$manufacturer) {
            return new JsonResponse(404, ['result'=> 'not found', 'slug'=>$slug]);
        }
        return  new ManufactureResource($manufacturer);
    }

    public function menu()
    {
        $settings = new GeneralDesignSettings();
        $categoriesLimit = $settings->mainMenuCatCount;

        $collection = Manufacturer::Active()
            ->whereIn('id', array_values($settings->mainMenuBrands))
//            ->orderBy(\request('order', 'position'), \request('direction', 'asc'))
            ->with(['categories' => function($query) use ($categoriesLimit) { $query->take($categoriesLimit); }])
            ->get();

        return ManufactureResource::collection($collection);
    }


}