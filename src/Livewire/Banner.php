<?php

namespace Kenepa\Banner\Livewire;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Kenepa\Banner\ValueObjects\Banner as BannerObject;
use Livewire\Component;

class Banner extends Component
{
    /**
     * @var BannerObject[]
     */
    public ?Collection $banners;

    public function render()
    {
        return view('banner::components.banner');
    }

    public function mount()
    {
        $this->getBanners();
    }

    public function getBanners()
    {
        $this->banners = collect(Cache::get('kenepa::banners', []));
    }
}
