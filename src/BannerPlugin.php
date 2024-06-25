<?php

namespace Kenepa\Banner;

use Kenepa\Banner\Livewire\BannerManagerPage;
use Filament\Contracts\Plugin;
use Filament\Panel;

class BannerPlugin implements Plugin
{
    public function getId(): string
    {
        return 'banner';
    }

    public function register(Panel $panel): void
    {
        $panel->pages([
           BannerManagerPage::class
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
