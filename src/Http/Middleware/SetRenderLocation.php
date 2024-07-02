<?php

namespace Kenepa\Banner\Http\Middleware;

use Filament\Support\Facades\FilamentView;
use Kenepa\Banner\Facades\BannerManager;

class SetRenderLocation
{
    public function handle($request, \Closure $next)
    {
        $banner = BannerManager::getAll();


        foreach ($banner as $banner) {
            FilamentView::registerRenderHook(
                $banner->render_location,
                fn () => view('banner::components.banner', ['banner' => $banner]),
            );
        }

        return $next($request);
    }
}
