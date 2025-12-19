<?php

namespace App\Http\Resources;

use App\Traits\NoImage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\CollectsResources;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ManufactureResource extends JsonResource
{
    use NoImage;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image ?: $this->noimage('170'),
            'position' => $this->position,
            'slug' => $this->slug,
            'manufacturer' => $this->name,
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
        ];
    }
}