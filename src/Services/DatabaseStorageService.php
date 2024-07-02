<?php

namespace Kenepa\Banner\Services;

use Kenepa\Banner\Contracts\BannerStorage;
use Kenepa\Banner\ValueObjects\BannerData;

class DatabaseStorageService implements BannerStorage
{

    public function store(BannerData $data)
    {
        // TODO: Implement store() method.
    }

    public function delete(string $bannerId)
    {
        // TODO: Implement delete() method.
    }

    public function get(string $bannerId)
    {
        // TODO: Implement get() method.
    }

    public function getAll(): array
    {
        // TODO: Implement getAll() method.
    }
}
