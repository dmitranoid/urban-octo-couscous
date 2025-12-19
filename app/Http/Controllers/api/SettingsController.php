<?php

namespace App\Http\Controllers\api;

use App\Http\Resources\SettingsResource;
use App\Settings\GeneralDesignSettings;
use Illuminate\Http\JsonResponse;

class SettingsController
{
    public function bySection(string $section)
    {

        $settings = match ($section) {
            'general-design' => new GeneralDesignSettings(),
            'default' => null,

        };
        if (empty($settings)) {
            return new JsonResponse(['result' => 'not found'], 404);
        }
        return SettingsResource::make($settings->toArray());
    }
}