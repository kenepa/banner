<?php

use Illuminate\Support\Facades\Cache;
use Kenepa\Banner\BannerManager;
use Kenepa\Banner\Contracts\BannerStorage;
use Kenepa\Banner\Services\CacheStorageService;
use Kenepa\Banner\ValueObjects\BannerData;

beforeEach(function () {
    app()->singleton(BannerStorage::class, function () {
        return new CacheStorageService();
    });
});

it('can store a banner', function () {
    $bannerRawData = $this->generateRawBannerData();
    $banner = BannerData::fromArray($bannerRawData);

    BannerManager::store($banner);

    $storedCacheBanners = Cache::get('kenepa::banners');
    expect($storedCacheBanners[0])
        ->toBeArray()
        ->toBe($bannerRawData);
});

it('can retrieve a banner', function () {
    $bannerRawData = $this->generateRawBannerData();
    Cache::put('kenepa::banners', [$bannerRawData]);

    $banners = BannerManager::getAll();

    expect($banners[0])
        ->toMatchObject($bannerRawData);
});

it('can delete a banner', function () {
    $bannerRawData = $this->generateRawBannerData();
    Cache::put('kenepa::banners', [$bannerRawData]);

    BannerManager::delete($bannerRawData['id']);

    expect(Cache::get('kenepa::banners'))->toBeEmpty();
});

it('can update a banner', function () {
    $bannerRawData = $this->generateRawBannerData();
    Cache::put('kenepa::banners', [$bannerRawData]);
    $bannerRawUpdated = $this->generateRawBannerData();

    BannerManager::update(BannerData::fromArray($bannerRawUpdated));

    $banners = BannerManager::getAll();
    expect($banners[0])
        ->toMatchObject($bannerRawUpdated);
});
