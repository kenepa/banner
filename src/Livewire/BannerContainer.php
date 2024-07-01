<?php

namespace Kenepa\Banner\Livewire;

use Kenepa\Banner\BannerManager;
use Livewire\Component;

class BannerContainer extends Component
{
    /**
     * @var BannerContainer[]
     */
    public array $banners;

    public function render()
    {
        return view('banner::components.banner-container');
    }

    public function mount()
    {
        $this->getBanners();
    }

    public function getBanners()
    {
        $this->banners = BannerManager::getAll();
    }
}
