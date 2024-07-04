<?php

namespace Kenepa\Banner\Services;

use Illuminate\Support\Facades\Cache;
use Kenepa\Banner\Banner;
use Kenepa\Banner\Contracts\BannerStorage;
use Kenepa\Banner\ValueObjects\BannerData;

class CacheStorageService implements BannerStorage
{
    public function store(BannerData $data)
    {
        $banner = $data;

        if ($banner->is_active) {
            $banner->active_since = now();
        } else {
            $banner->active_since = null;
        }

        $banners = $this->getAllAsArray();
        $banners[] = $banner->toArray();

        Cache::put('kenepa::banners', $banners);
    }

    public function delete(string $bannerId)
    {
        $banners = $this->getAllAsArray();
        $bannerIndex = $this->getIndex($bannerId);

        array_splice($banners, $bannerIndex, 1);

        Cache::put('kenepa::banners', $banners);
    }

    public function get(string $bannerId)
    {
        // TODO: Implement get() method.
    }

    /**
     * @return Banner[]
     */
    public function getAll(): array
    {
        $bannerData = $this->getAllAsBannerData();
        $bannerObjects = [];

        foreach ($bannerData as $data) {
            $bannerObjects[] = Banner::fromData($data);
        }

        return $bannerObjects;
    }

    public function getAllAsArray(): array
    {
        return Cache::get('kenepa::banners', []);
    }

    public function getAllAsBannerData(): array
    {
        $bannersRaw = Cache::get('kenepa::banners', []);
        $bannerData = [];
        foreach ($bannersRaw as $data) {
            $bannerData[] = BannerData::fromArray($data);
        }

        return $bannerData;
    }

    public function update(BannerData $data)
    {
        $updatedBannerData = $data;

        if ($updatedBannerData->is_active) {
            $updatedBannerData->active_since = now();
        } else {
            $updatedBannerData->active_since = null;
        }

        $bannerIndex = $this->getIndex($updatedBannerData->id);
        $banners = $this->getAllAsArray();
        $banners[$bannerIndex] = $updatedBannerData->toArray();

        Cache::put('kenepa::banners', $banners);
    }

    public function getActiveBanners(): array
    {
        $banners = $this->getAll();

        return array_filter($banners, function (Banner $banner) {
            return $banner->is_active;
        });
    }

    public function getActiveBannerCount(): int
    {
        $banners = $this->getActiveBanners();

        return count($banners);
    }

    public function enableAllBanners(): void
    {
        $banners = $this->getAllAsArray();

        foreach ($banners as $key => $value) {
            $banners[$key]['is_active'] = true;
        }

        Cache::put('kenepa::banners', $banners);
    }

    public function disableAllBanners(): void
    {
        $banners = static::getAllAsArray();

        foreach ($banners as $key => $value) {
            $banners[$key]['is_active'] = false;
        }

        Cache::put('kenepa::banners', $banners);
    }

    public function getIndex(string $bannerId): int | bool
    {
        $banners = $this->getAll();

        return array_search($bannerId, array_column($banners, 'id'));
    }
}
