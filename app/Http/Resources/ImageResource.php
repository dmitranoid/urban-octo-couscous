<?php

namespace App\Http\Resources;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'parent_id' => $this->parent_id,
            'page' => PageResource::make(Page::Active()->find($this->parent_id)),
            'name' => $this->name,
            'slug' => $this->slug,
            'seo' => $this->seo,
            'content' => $this->content,
            'image' => $this->image,
            'params' => $this->params,
            'position' => $this->position,
        ];
    }
}
