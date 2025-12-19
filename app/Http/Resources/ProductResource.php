<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Traits\NoImage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    use NoImage;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'name' => $this->name,
            'description' => $this->description,
            'slug' => $this->slug,
            'image' => $this->image ?: $this->noimage(),
            'images' => $this->images,
            'options' => $this->options,
            'features' => $this->features,
            'manufacturer_id' => $this->manufacturer_id,
            'manufacturer' => ManufactureResource::make($this->manufacturer),
            'category_id' => $this->category_id,
            'category' => CategoryResource::make($this->category),
            'files' => $this->attachment,
            'position' => $this->position,
            'stock' => $this->stock,
            'partner_stock' => $this->partner_stock,
            'price'=> $this->price,
        ];
    }

}