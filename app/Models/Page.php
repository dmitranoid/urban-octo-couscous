<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Page extends Element
{
    use HasFactory, AsSource, Filterable;

    protected $attributes = [
        'type' => self::ELEMENT_PAGE,
        'seo' => '{"1":{"Attribute":"title","Value":"page_title"},"2":{"Attribute":"description","Value":"page_description"}}',
    ];

//        'seo' => json_encode([
//            '1' => ['Attribute' => 'title', 'Value'=>'page_title'],
//            '2' => ['Attribute' => 'description', 'Value'=>'page_description'],
//        ]),

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('pages', function (Builder $builder) {
            $builder->where('type', self::ELEMENT_PAGE);
        });
    }

    public function elements():HasMany
    {
        return  $this->hasMany(Element::class, 'parent_id', 'id');
    }

}
