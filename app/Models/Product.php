<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereMaxMin;
use Orchid\Screen\AsSource;
use function PHPUnit\Framework\arrayHasKey;

class Product extends Model
{
    use HasFactory, AsSource, Filterable, Attachable;

    const STATUS = [
        false => 'не активен',
        true => 'активен',
    ];

    protected $fillable = [
        'sku',
        'name',
        'description',
        'slug',
        'image',
        'images',
        'stock',
        'partner_stock',
        'price',
        'meta_title',
        'meta_description',
        'manufacturer_id',
        'category_id',
        'is_active',
    ];

    protected $casts = [
        'options' => 'array',
        'files' => 'array',
        'is_active' => 'boolean',
    ];

    protected $allowedSorts = [
        'name',
        'slug',
        'position',
        'is_active',
        'price',
        'stock',
        'partner_stock',
    ];

    protected $allowedFilters = [
        'id' => Where::class,
        'is_active' => Where::class,
        'sku' => Like::class,
        'name' => Like::class,
        'slug' => Like::class,
        'position' => WhereMaxMin::class,
        'stock' => WhereMaxMin::class,
        'partner_stock' => WhereMaxMin::class,
        'price' => WhereMaxMin::class,
    ];

    private static array $defaultFeatures = [
        'warranty' => ['slug' => 'warranty', 'icon' => '/assets/images/catalog-product-warranty.svg', 'title' => '12-month warranty', 'isActive' => true],
        'delivery' => ['slug' => 'delivery', 'icon' => '/assets/images/catalog-product-delivery.svg', 'title' => 'Global delivery', 'isActive' => true],
        'dispatch' => ['slug' => 'dispatch', 'icon' => '/assets/images/catalog-product-dispatch.svg', 'title' => 'Immediate dispatch', 'isActive' => true],
    ];


    protected static function booted(): void
    {
        static::created(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->sku);
            }
        });

        static::updating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->sku);
            }
        });
    }


    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeRelatedProducts($query, $count = 10, $inRandomOrder = true)
    {
        $query = $query->where('manufacturer_id', $this->manufacturer_id)
            ->where('category_id', $this->category_id);

        if ($inRandomOrder) {
            $query = $query->inRandomOrder();
        };

        $query->take($count);
    }

    public function related($count = 10, $inRandomOrder = true): HasMany
    {
        return $this->hasMany(Product::class, 'manufacturer_id', 'manufacturer_id')
            ->where('category_id', $this->category_id);
    }


    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', 1);
    }

    public function getFeaturesAttribute()
    {
        $options = $this->options;
//        $changedFeatures = $this->options['features']??[];
        $changedFeatures = $options ?? [];
        $features = [];
        foreach (self::$defaultFeatures as $key => $feature) {
            $features[$key] = $feature;
            if (array_key_exists($key, $changedFeatures)) {
                $features[$key]['isActive'] = (bool)$changedFeatures[$key];
            }
        }
        return $features;
    }


    public static function getDefaultFeatures(): array
    {
        return self::$defaultFeatures;
    }

    public static function getChangedFeatures(array $features): array
    {
        $changedFeatures = [];
        foreach (self::getDefaultFeatures() as $key => $feature) {
            if (array_key_exists('isActive', $features[$key]) && ($feature['isActive'] != (bool)$features[$key]['isActive'])) {
                $changedFeatures[$key] = (bool)$features[$key]['isActive'];
            }
        }
        return $changedFeatures;
    }
}