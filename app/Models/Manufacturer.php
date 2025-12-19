<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Screen\AsSource;

class Manufacturer extends Model
{
    use HasFactory, AsSource, Filterable;

    protected $attributes = [
        'position' => 100,
    ];


    protected $fillable = [
        'name',
        'slug',
        'image',
        'position',
        'is_active',
    ];

    protected $allowedSorts = [
        'name',
        'slug',
        'position',
        'is_active',
    ];

    protected $allowedFilters = [
        'id' => Where::class,
        'is_active' => Where::class,
        'name' => Like::class,
        'slug' => Like::class,
        'position' => Where::class,
    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];


    protected static function booted(): void
    {
        static::created(function (Manufacturer $manufacturer) {
            if(empty($manufacturer->slug)) {
                $manufacturer->slug = Str::slug($manufacturer->name);
            }
        });

        static::updating(function (Manufacturer $manufacturer) {
            if(empty($manufacturer->slug)) {
                $manufacturer->slug = Str::slug($manufacturer->name);
            }
        });

    }

    public function scopeActive($query): void
    {
        /** var Builder $query */
        $query->where('is_active', 1);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function categories():HasMany
    {
        return $this->hasMany(Category::class);
    }

}