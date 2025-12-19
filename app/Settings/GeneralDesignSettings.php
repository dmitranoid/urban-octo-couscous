<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralDesignSettings extends Settings
{

    public string $title;

    public string $phone;

    public string $email;

    public string $address;

    public array $mainMenuBrands;

    public int $mainMenuCatCount;


    public static function group(): string
    {
        return 'design';
    }
}