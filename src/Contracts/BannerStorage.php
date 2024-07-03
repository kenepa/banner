<?php

namespace Kenepa\Banner\Contracts;

use Kenepa\Banner\Banner;
use Kenepa\Banner\ValueObjects\BannerData;

interface BannerStorage
{
    public function store(BannerData $data);

    public function update(BannerData $data);

    public function delete(string $bannerId);

    public function get(string $bannerId);

    /**
     * @return Banner[]
     */
    public function getAll(): array;

    /**
     * @return ValueObjects\BannerData[]
     */
    public function getActiveBanners(): array;

    public function getActiveBannerCount(): int;

    public function disableAllBanners(): void;

    public function enableAllBanners(): void;
}
