<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Testing\Concerns\AssertsStatusCodes;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDate;
use Orchid\Filters\Types\WhereMaxMin;
use Orchid\Screen\AsSource;

class OrderProduct extends Model
{
    use HasFactory, AsSource, Filterable;

    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'price',
        'product_data',
    ];

    protected $allowedSorts = [
        'order_id',
        'product_id',
        'qty',
        'price',
        'product_data',
        ];

    protected $allowedFilters = [
        'order_id' => Where::class,
        'product_id' => Where::class,
        'qty' => WhereMaxMin::class,
        'price' => WhereMaxMin::class,
        'product_data' => WhereDate::class,
        ];


    public function order():BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
