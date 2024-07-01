<?php

namespace Kenepa\Banner;

use Illuminate\Support\Facades\Cache;

class BannerManager
{
    /**
     * @return Banner[]
     */
    public static function getAll(): array
    {
        $bannerData = Cache::get('kenepa::banners', []);
        $bannerObjects = [];

        foreach ($bannerData as $data) {
            $bannerObjects[] = Banner::fromData($data);
        }

        return $bannerObjects;
    }

    public static function store(ValueObjects\BannerData $data): void
    {
        $banners = static::getAll();

        $banner = $data;

        if ($banner->is_active) {
            $banner->active_since = now();
        } else {
            $banner->active_since = null;
        }

        $banner->id = uniqid();

        $banners[] = $banner;

        Cache::put('kenepa::banners', $banners);

        //todo: add try catch
    }

    public static function update(array $data): void
    {
        $banners = static::getAll();
        $updatedBannerData = ValueObjects\BannerData::fromArray($data);

        // TODO fix active since overwrite
        if ($updatedBannerData->is_active) {
            $updatedBannerData->active_since = now();
        } else {
            $updatedBannerData->active_since = null;
        }

        $bannerIndex = static::getIndex($updatedBannerData->id);
        $banners[$bannerIndex] = $updatedBannerData;

        Cache::put('kenepa::banners', $banners);
    }

    public static function delete(string $bannerId)
    {
        $banners = static::getAll();
        $bannerIndex = static::getIndex($bannerId);

        array_splice($banners, $bannerIndex, 1);

        Cache::put('kenepa::banners', $banners);
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
        $banners = static::getAll();

        return array_filter($banners, function (Banner $banner) {
            return $banner->is_active;
        });
    }

    public static function getActiveBannerCount(): int
    {
        $banners = static::getActiveBanners();

        return count($banners);
    }
}
