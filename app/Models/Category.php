<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Screen\AsSource;

class Category extends Model
{
    use HasFactory, AsSource, Filterable;

    protected $fillable = [
        'manufacturer_id',
        'name',
        'slug',
        'image',
        'description',
        'parent_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $allowedFilters = [
        'id' => Where::class,
        'is_active'  => Where::class,
        'name'       => Like::class,
        'slug'       => Like::class,
    ];

    protected $allowedSorts = [
        'id',
        'name',
        'slug',
        'is_active',
    ];


    protected static function booted(): void
    {
        static::created(function (Category $category) {
            if(empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function (Category $category) {
            if(empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', 1);
    }

    public function manufacturer():BelongsTo
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function products():HasMany
    {
        return $this->hasMany(Product::class);
    }
}
