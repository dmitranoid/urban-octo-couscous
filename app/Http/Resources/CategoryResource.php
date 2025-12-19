<?php

namespace App\Http\Resources;

use App\Traits\NoImage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'image' => $this->image ?: $this->noimage(),
            'images' => $this->images,
            'description' => $this->description,
            'parent_id' => $this->parent_id,
            'manufacturer_id' => $this->manufacturer_id,
            'manufacturer' => $this->whenLoaded('manufacturer', ManufactureResource::make($this->manufacturer)),
        ];
    }
}
