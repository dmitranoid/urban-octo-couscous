<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class BasketProduct extends Model
{
    use HasFactory, AsSource, Filterable;

    protected $fillable = [
        'owner',
        'owner_type',
        'product_id',
        'qty',
        'price',
    ];

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

}
