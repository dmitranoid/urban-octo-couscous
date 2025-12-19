<?php

namespace App\Http\Controllers\api;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Config;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var Builder $query */
        $query = Product::Active()
            ->with('category', 'manufacturer')
            ->orderBy(\request('order', 'id'), \request('direction', 'asc'));
        if (\request('manufacturer_id', false)) {
            $query->where('manufacturer_id', \request('manufacturer_id'));
        };
        if (\request('category_id', false)) {
            $query->where('category_id', \request('category_id'));
        };
        return ProductResource::collection($query->paginate(request('perPage', Config::get('app.limit')), '*','page'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //$product = Product::findOrFail($id);
        return ProductResource::make($product->load(['category', 'manufacturer']));
    }

    /**
     * Display the specified resource.
     */
    public function related(string $id)
    {
        $limit = \request('limit', 10);
        $product = Product::findOrFail($id);
        return ProductResource::collection($product->relatedProducts($limit)->get());
    }

    public function search()
    {
        if (empty($text = \request('str'))) {
            return \abort(400, json_encode(['error'=>'search string must be specified']));
        }
        /** @var Builder $query */
        $query = Product::Active()
            ->where('sku', 'like', '%'. $text . '%')
            ->orWhere('name', 'LIKE', '%' . $text . '%')
            ->with('category', 'manufacturer')
            ->orderBy(\request('order', 'id'), \request('direction', 'asc'));
        if (\request('manufacturer_id', false)) {
            $query->where('manufacturer_id', \request('manufacturer_id'));
        };
        if (\request('category_id', false)) {
            $query->where('category_id', \request('category_id'));
        };
        return ProductResource::collection($query->paginate(request('limit', Config::get('app.limit'))));
    }

    public function top()
    {
        /** @var Builder $query */
        $query = Product::Active()->with('category', 'manufacturer')
            ->orderBy(\request('order', 'id'), \request('direction', 'asc'));
        if (\request('manufacturer_id', false)) {
            $query->where('manufacturer_id', \request('manufacturer_id'));
        };
        if (\request('category_id', false)) {
            $query->where('category_id', \request('category_id'));
        };
        return ProductResource::collection($query->paginate(request('limit', Config::get('app.limit'))));
    }


    public function bySlug(string $slug)
    {
        /** @var Builder $query */
        $query = Product::Active()
            ->where('slug', \request('slug'))
            ->with('category', 'manufacturer');
        if (\request('manufacturer_id', false)) {
            $query->where('manufacturer_id', \request('manufacturer_id'));
        };
        if (\request('category_id', false)) {
            $query->where('category_id', \request('category_id'));
        };

        $data = $query->first();

        if (!$data) {
            return new JsonResponse(['result' => 'not found', 'sku' => $slug], 404);
        }

        return ProductResource::make($data);
    }


}