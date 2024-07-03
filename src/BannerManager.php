<?php

namespace Kenepa\Banner;

use Kenepa\Banner\Contracts\BannerStorage;
use Kenepa\Banner\ValueObjects\BannerData;

class BannerManager
{
    /**
     * @return Banner[]
     */
    public static function getAll(): array
    {
        $storage = app(BannerStorage::class);

        return $storage->getAll();
    }

    public static function store(ValueObjects\BannerData $data): void
    {
        $storage = app(BannerStorage::class);
        $storage->store($data);
    }

    public static function update(BannerData $data): void
    {
        $storage = app(BannerStorage::class);
        $storage->update($data);
    }

    public static function delete(string $bannerId)
    {
        $storage = app(BannerStorage::class);
        $storage->delete($bannerId);
    }

    public static function getIndex(string $bannerId): int | bool
    {
        $banners = static::getAll();

        return array_search($bannerId, array_column($banners, 'id'));
    }

    /**
     * @return ValueObjects\BannerData[]
     */
    public static function getActiveBanners(): array
    {
        $storage = app(BannerStorage::class);

        return $storage->getActiveBanners();
    }

    public static function getActiveBannerCount(): int
    {
        $storage = app(BannerStorage::class);

        return $storage->getActiveBannerCount();
    }

    public static function disableAllBanners(): void
    {
        $storage = app(BannerStorage::class);
        $storage->disableAllBanners();
    }

    public static function enableAllBanners(): void
    {
        $storage = app(BannerStorage::class);
        $storage->enableAllBanners();
    }
}
