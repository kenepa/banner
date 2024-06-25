<?php

namespace Kenepa\Banner\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Kenepa\Banner\Banner
 */
class Banner extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Kenepa\Banner\Banner::class;
    }
}
