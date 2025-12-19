<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class MessageQuestion extends Message
{
    use HasFactory, AsSource, Filterable;

    protected $table = 'messages';

    protected $attributes =[
        'type' =>  self::MSG_QUESTION,
    ];


    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('question', function (Builder $builder) {
            $builder->where('type', self::MSG_QUESTION);
        });
    }
}
