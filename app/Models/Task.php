<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'name',
        'status',
        'message',
        'inParams',
        'outParams',
        'log_file',
    ];

    protected $casts = [
      'inParams' => 'array',
      'outParams' => 'array',
    ];
}