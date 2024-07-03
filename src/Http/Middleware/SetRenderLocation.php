<?php

namespace Kenepa\Banner\Http\Middleware;

use Filament\Support\Facades\FilamentView;
use Kenepa\Banner\Facades\BannerManager;

class SetRenderLocation
{
    public function handle($request, \Closure $next)
    {
        $banners = BannerManager::getAll();

        foreach ($banners as $banner) {
            if ($banner->isVisible()) {
                FilamentView::registerRenderHook(
                    $banner->render_location,
                    fn () => view('banner::components.banner', ['banner' => $banner]),
                    scopes: empty($banner->scope) ? null : $banner->scope
                );
            }
        }

        return $next($request);
    }
}
