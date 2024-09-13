<?php

namespace Kenepa\Banner;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Kenepa\Banner\Contracts\BannerStorage;
use Kenepa\Banner\Http\Middleware\SetRenderLocation;
use Kenepa\Banner\Livewire\BannerManagerPage;
use Kenepa\Banner\Services\CacheStorageService;
use Kenepa\Banner\Services\DatabaseStorageService;

class BannerPlugin implements Plugin
{
    protected bool $persistBannersInDatabase = false;

    protected ?string $title = 'banner::manager.title';

    protected ?string $subheading = 'banner::manager.subheading';

    protected ?string $navigationIcon = 'heroicon-o-megaphone';

    protected ?string $navigationLabel = 'banner::manager.navigation_label';

    protected ?string $navigationGroup = '';

    protected ?int $navigationSort = null;

    protected ?string $bannerManagerAccessPermission = null;

    protected ?bool $disableBannerManager = false;

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
            SetRenderLocation::class,
        ], true);

        app()->singleton(BannerStorage::class, function () {
            if ($this->persistBannersInDatabase) {
                return new DatabaseStorageService();
            }

            return new CacheStorageService();
        });
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public function persistsBannersInDatabase(): static
    {
        $this->persistBannersInDatabase = true;

        return $this;
    }

    public function title(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): ?string
    {
        return __($this->title);
    }

    public function subheading(string $subheading): static
    {
        $this->subheading = $subheading;

        return $this;
    }

    public function getSubheading(): string
    {
        return __($this->subheading);
    }

    public function navigationIcon(?string $icon): static
    {
        $this->navigationIcon = $icon;

        return $this;
    }

    public function getNavigationIcon(): ?string
    {
        return $this->navigationIcon;
    }

    public function navigationGroup(string $group): static
    {
        $this->navigationGroup = $group;

        return $this;
    }

    public function getNavigationGroup(): string
    {
        return $this->navigationGroup;
    }

    public function navigationSort(?int $sort): static
    {
        $this->navigationSort = $sort;

        return $this;
    }

    public function getNavigationSort(): ?int
    {
        return $this->navigationSort;
    }

    public function getNavigationLabel()
    {
        return __($this->navigationLabel);
    }

    public function navigationLabel(?string $label): static
    {
        $this->navigationLabel = $label;

        return $this;
    }

    public function bannerManagerAccessPermission(?string $permission): static
    {
        $this->bannerManagerAccessPermission = $permission;

        return $this;
    }

    public function getBannerManagerAccessPermission(): ?string
    {
        return $this->bannerManagerAccessPermission;
    }

    public function disableBannerManager(bool $disable = true): static
    {
        $this->disableBannerManager = $disable;

        return $this;
    }

    public function getDisableBannerManager(): bool
    {
        return $this->disableBannerManager;
    }
}
