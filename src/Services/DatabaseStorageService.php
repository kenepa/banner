<?php

namespace Kenepa\Banner\Services;

use Kenepa\Banner\Contracts\BannerStorage;
use Kenepa\Banner\Models\Banner as BannerModel;
use Kenepa\Banner\ValueObjects\BannerData;

class DatabaseStorageService implements BannerStorage
{

    public function store(BannerData $data)
    {
        BannerModel::create(['data' => $data->toArray()]);
    }

    public function delete(string $bannerId)
    {
        BannerModel::whereJsonContains('data->id', $bannerId)->get()->first()->delete();
    }

    public function get(string $bannerId)
    {
        // TODO: Implement get() method.
    }

    /**
     * @return array|\Kenepa\Banner\Banner[]
     */
    public function getAll(): array
    {
        $banners = BannerModel::all()->map(function (BannerModel $banner) {
           return \Kenepa\Banner\Banner::fromData(BannerData::fromArray($banner->data));
        });

        return $banners->toArray();
    }

    public function update(BannerData $data)
    {
        BannerModel::whereJsonContains('data->id', $data->id)->get()->first()->update(['data' => $data]);
    }

    public function getAllAsArray(): array
    {
        return BannerModel::all()->map(function (BannerModel $banner) {
            return $banner->data;
        })->toArray();
    }

    public function getAllAsBannerData(): array
    {
        return BannerModel::all()->map(function (BannerModel $banner) {
            return BannerData::fromArray($banner->data);
        })->toArray();
    }

    public function getActiveBanners(): array
    {
        return BannerModel::all()->where('is_active', true)->toArray();
    }

    public function getActiveBannerCount(): int
    {
        return count($this->getActiveBanners());
    }

    public function disableAllBanners(): void
    {
        BannerModel::query()->update([
            'data->is_active' => false
        ]);
    }

    public function enableAllBanners(): void
    {
        BannerModel::query()->update([
            'data->is_active' => true
        ]);
    }
}
