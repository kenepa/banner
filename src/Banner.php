<?php

namespace Kenepa\Banner;

use Illuminate\Support\Facades\Cache;

class Banner
{
    public static function getAll(): array
    {
        return Cache::get('kenepa::banners', []);
    }

    public static function store(ValueObjects\Banner $data): void
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
        $updatedBannerData = $data;

        // TODO fix active since overwrite
        if ($data['is_active']) {
            $updatedBannerData['active_since'] = now();
        } else {
            $updatedBannerData['active_since'] = null;
        }

        $bannerIndex = static::getIndex($updatedBannerData['id']);
        $banners[$bannerIndex] = $updatedBannerData;

        Cache::put('kenepa::banners', $banners);
    }

    public static function getIndex(string $bannerId): int | bool
    {
        $banners = static::getAll();

        return $banners->search(function (array $banner) use ($bannerId) {
            return $banner['id'] === $bannerId;
        });
    }
}
