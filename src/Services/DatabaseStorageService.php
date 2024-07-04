<?php

namespace Kenepa\Banner\Services;

use Illuminate\Support\Facades\Cache;
use Kenepa\Banner\Banner;
use Kenepa\Banner\Contracts\BannerStorage;
use Kenepa\Banner\Models\Banner as BannerModel;
use Kenepa\Banner\ValueObjects\BannerData;

class DatabaseStorageService implements BannerStorage
{
    public function store(BannerData $data)
    {
        BannerModel::create(['data' => $data->toArray()]);
        $this->forgetCache();
    }

    public function update(BannerData $data)
    {
        $updatedBannerData = $data;

        if ($updatedBannerData->is_active) {
            $updatedBannerData->active_since = now();
        } else {
            $updatedBannerData->active_since = null;
        }

        BannerModel::whereJsonContains('data->id', $data->id)->get()->first()->update(['data' => $updatedBannerData]);
        $this->forgetCache();
    }

    public function delete(string $bannerId)
    {
        BannerModel::whereJsonContains('data->id', $bannerId)->get()->first()->delete();
        $this->forgetCache();
    }

    public function get(string $bannerId)
    {
        // TODO: Implement get() method.
    }

    /**
     * @return array|Banner[]
     */
    public function getAll(): array
    {
        $banners = Cache::rememberForever('kenepa::db-banners', function () {
            return BannerModel::all()->map(function (BannerModel $banner) {
                return Banner::fromData(BannerData::fromArray($banner->data));
            });
        });

        return $banners->toArray();
    }

    public function getActiveBanners(): array
    {
        return Cache::rememberForever('kenepa::db-active-banners', function () {
            return BannerModel::all()->where('is_active', true)->toArray();
        });
    }

    public function getActiveBannerCount(): int
    {
        return count($this->getActiveBanners());
    }

    public function disableAllBanners(): void
    {
        BannerModel::query()->update([
            'data->is_active' => false,
        ]);
        $this->forgetCache();
    }

    public function enableAllBanners(): void
    {
        BannerModel::query()->update([
            'data->is_active' => true,
        ]);
        $this->forgetCache();
    }

    public function forgetCache(): void
    {
        Cache::deleteMultiple(['kenepa::db-banners', 'kenepa::db-active-banner']);
    }
}
