<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Orchid\Filters\Filter;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Screen\AsSource;

class Element extends Model
{
    use HasFactory, AsSource, Filterable;

    const ELEMENT_PAGE = 'page';
    const ELEMENT_BLOCK = 'block';
    const ELEMENT_LIST = 'ul';
    const ELEMENT_LISTITEM = 'li';
    const ELEMENT_IMAGE = 'image';
    const ELEMENT_IMAGES = 'images';

    protected $table = 'elements';

    protected $fillable = [
        'parent_id',
        'name',
        'type',
        'slug',
        'seo',
        'content',
        'image',
        'images',
        'params',
        'position',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'images' => 'array',
        'params' => 'array',
        'seo' => 'array',
    ];

    protected $allowedFilters = [
        'name' => Like::class,
        'type' => Where::class,
        'slug' => Like::class,
        'content' => Like::class,
        'is_active' => Where::class,
    ];

    protected $allowedSort = [
        'id',
        'name',
        'type',
        'slug',
        'content',
        'is_active',
    ];

    protected static function booted(): void
    {
        parent::booted();

        static::creating(function (Element $element) {
            if(empty($element->slug)) {
                $element->slug = Str::slug($element->name);
            }
        });

        static::updating(function (Element $element) {
            if(empty($element->slug)) {
                $element->slug = Str::slug($element->name);
            }
        });
    }

    public function scopeActive($query):void
    {
        $query->where('is_active', 1);
    }


    public function scopeOnlyPages($query):void
    {
        /** @var Builder */
        $query->where('type', self::ELEMENT_PAGE);
    }

    public function scopeOnlyElements($query):void
    {
        /** @var Builder */
        $query->where('type', '<>' , self::ELEMENT_PAGE);
    }

    public function page():BelongsTo
    {
        return $this->belongsTo(Element::class, 'parent_id');
    }

    public function elements():HasMany
    {
        return $this->hasMany(Element::ELEMENT_IMAGE, 'parent_id');
    }
}