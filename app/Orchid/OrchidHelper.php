<?php

declare(strict_types=1);

namespace App\Orchid;

use Illuminate\Support\Facades\Blade;
use Orchid\Icons\IconComponent;

class OrchidHelper
{
    public static function renderBoolAsIcon(bool $value, bool $coloured = true):string
    {
        return Blade::renderComponent(
            new IconComponent(
                path: $value ? 'bs.check-circle' : 'bs.circle',
                fill: $coloured ? ($value ? 'green' : 'red') : '',
            )
        );
    }

    public static function statusTextArray(): array
    {
        return[
            0 => 'disabled',
            1 => 'active',
        ];
    }
}