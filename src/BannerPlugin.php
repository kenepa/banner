<?php

namespace Kenepa\Banner;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Kenepa\Banner\Http\Middleware\SetRenderLocation;
use Kenepa\Banner\Livewire\BannerManagerPage;

class BannerPlugin implements Plugin
{
    public function getId(): string
    {
        return 'banner';
    }

    public function register(Panel $panel): void
    {
        $panel->pages([
            BannerManagerPage::class,
        ]);

        $panel->middleware([
            SetRenderLocation::class
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
