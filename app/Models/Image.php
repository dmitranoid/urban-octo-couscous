<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Image extends Element
{
    use HasFactory, AsSource, Filterable;

    protected $table = 'elements';

    protected $attributes =[
        'type' => self::ELEMENT_IMAGE,
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('pages', function (Builder $builder) {
            $builder->where('type', self::ELEMENT_IMAGE);
        });
    }
}
