<?php

namespace App\Http\Controllers\api;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $manufacturer_id = \request('manufacturer_id');
        $categories = Category::Active()
            ->orderBy(\request('order', 'id'), \request('direction', 'asc'));
        if ($manufacturer_id) {
            $categories->where('manufacturer_id', $manufacturer_id);
        }
        return CategoryResource::collection($categories->paginate(request('limit',  Config::get('app.limit'))));
    }

    public function top() {
        $manufacturer_id = \request('manufacturer_id');
        $categories = Category::Active()
            ->orderBy(\request('order', 'id'), \request('direction', 'asc'));
        if ($manufacturer_id) {
            $categories->where('manufacturer_id', $manufacturer_id);
        }
        return CategoryResource::collection($categories->limit(request('limit',  Config::get('app.limit')))->get());

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //todo Check is active
        if (!$category->is_active) {
            abort(404);
        }
        return CategoryResource::make($category);
    }

    public function bySlug(string $slug)
    {
        $category = Category::Active()->where('slug', $slug);
        if ($manufacturer_id = \request('manufacturer_id')) {
            $category->where('manufacturer_id', $manufacturer_id);
        }
        if (!$category) {
            return new JsonResponse(404, ['result'=> 'not found', 'slug'=>$slug]);
        }
        return  new CategoryResource($category->with('manufacturer')->first());
    }
}