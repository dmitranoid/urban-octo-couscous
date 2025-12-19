<?php

declare(strict_types=1);

namespace App\Traits;

trait NoImage
{
    public function noimage(string $size = '300')
    {
        return '/assets/images/noimage/no-image-' . $size . '.png';
    }
}