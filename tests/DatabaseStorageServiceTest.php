<?php

use Illuminate\Support\Facades\Cache;
use Kenepa\Banner\BannerManager;
use Kenepa\Banner\Contracts\BannerStorage;
use Kenepa\Banner\Models\Banner;
use Kenepa\Banner\Services\DatabaseStorageService;
use Kenepa\Banner\ValueObjects\BannerData;

use function Pest\Laravel\assertDatabaseCount;

beforeEach(function () {
    app()->singleton(BannerStorage::class, function () {
        return new DatabaseStorageService();
    });
});

it('can store a banner', function () {
    $bannerRawData = $this->generateRawBannerData();
    $banner = BannerData::fromArray($bannerRawData);

    BannerManager::store($banner);

    $storedDatabaseBanner = Banner::first();
    assertDatabaseCount('banners', 1);
    expect($storedDatabaseBanner->toArray()['data'])->toBe($bannerRawData);
});

it('can retrieve a banner', function () {
    $bannerRawData = $this->generateRawBannerData();
    Banner::create(['data' => $bannerRawData]);

    $banners = BannerManager::getAll();

    expect($banners[0]->toLivewire())
        ->toBe($bannerRawData)
        ->and(Cache::get('kenepa::db-banners')[0])
        ->toMatchObject($bannerRawData);
});

it('can delete a banner', function () {
    $bannerRawData = $this->generateRawBannerData();
    Banner::create(['data' => $bannerRawData]);

    BannerManager::delete($bannerRawData['id']);

    assertDatabaseCount('banners', 0);
    expect(Cache::get('kenepa::db-banner'))->toBeEmpty();
});

it('can update a banner', function () {
    $bannerRawData = $this->generateRawBannerData();
    $bannerRawUpdated = $this->generateRawBannerData();
    $bannerRawUpdated['id'] = $bannerRawData['id'];
    Banner::create(['data' => $bannerRawData]);

    BannerManager::update(BannerData::fromArray($bannerRawUpdated));

    $banners = BannerManager::getAll();
    expect($banners[0])
        ->toMatchObject($bannerRawUpdated)
        ->and(Cache::get('kenepa::db-banner'))
        ->toBeEmpty();
});
