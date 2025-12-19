<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('design.title', 'E-Trade Automation Company');
        $this->migrator->add('design.email', 'info@etrade-ag.com');
        $this->migrator->add('design.phone', '+48 786 434 232');
        $this->migrator->add('design.address', 'aleja Armii Krajowej 61, 50-541 Wrocław, Poland');
        $this->migrator->add('design.mainMenuBrands', []);
        $this->migrator->add('design.mainMenuCatCount', 5);
    }

    public function down():void {
        $this->migrator->delete('design.title');
        $this->migrator->delete('design.email');
        $this->migrator->delete('design.phone');
        $this->migrator->delete('design.address');
        $this->migrator->delete('design.mainMenuBrands');
        $this->migrator->delete('design.mainMenuCatCount');
    }
};