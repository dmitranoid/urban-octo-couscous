<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Screen\AsSource;

class Message extends Model
{
    use HasFactory, AsSource, Filterable;

    const MSG_CONTACT = 'contact';
    const MSG_QUESTION = 'question';
    const MSG_PRICE = 'price';

    const STATUS_NEW = 'new';
    const STATUS_READ = 'read';
    const STATUS_MAILED = 'mailed';
    const STATUS_ERROR = 'error';



    protected $fillable = [
        'type',
        'code',
        'status',
        'author',
        'contact',
        'message',
        'params',
    ];

    protected $allowedSorts = [
        'type',
        'status',
        'code',
        'author',
        'contact',
    ];
    protected $allowedFilters = [
        'type' => Where::class,
        'status' => Where::class,
        'code' => Like::class,
        'author' => Like::class,
        'contact' => Like::class,
        'message' => Like::class,
    ];

    protected $casts = [
      'params' => 'array',
    ];

    public function scopeInformations(Builder $query):void
    {
        $query->whereIn('type', [self::MSG_QUESTION, self::MSG_CONTACT]);
    }

    public function scopeOrders(Builder $query):void
    {
        $query->whereIn('type', [self::MSG_PRICE]);
    }

}