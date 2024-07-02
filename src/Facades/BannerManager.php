<?php

namespace Kenepa\Banner\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Kenepa\Banner\BannerManager
 */
class BannerManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Kenepa\Banner\BannerManager::class;
    }
}
