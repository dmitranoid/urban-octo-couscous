<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\WhereDate;
use Orchid\Filters\Types\WhereMaxMin;
use Orchid\Screen\AsSource;

class Order extends Model
{
    use HasFactory, AsSource, Filterable;

    protected $fillable = [
        'customer_id',
        'code',
        'place_date',
        'shipping_person',
        'shipping_address',
        'billing_address',
        'comment',
        'sum',
        'status',
        'payment_type',
        'payment_details',
    ];

    protected $casts = [
        'payment_type' => 'array',
        'payment_datails' => 'array',
    ];

    protected $allowedSorts = [
        'place_date',
        'sum',
        'status',
        'payment_type',
    ];

    protected $allowedFilters = [
        'code' => Like::class,
        'place_date' => WhereDate::class,
        'sum' => WhereMaxMin::class,
    ];


    public function customer():BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
