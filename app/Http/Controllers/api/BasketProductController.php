<?php

namespace App\Http\Controllers\api;

use App\Http\Requests\StoreBasketProductRequest;
use App\Http\Requests\UpdateBasketProductRequest;
use App\Models\BasketProduct;

class BasketProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBasketProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BasketProduct $basketProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBasketProductRequest $request, BasketProduct $basketProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BasketProduct $basketProduct)
    {
        //
    }
}