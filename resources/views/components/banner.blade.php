<div
    @class([
        'mt-4' => $banner->getLocation() === 'panel',
        '' => $banner->getLocation() === 'body',
        '' => $banner->getLocation() === 'nav',
        '' => $banner->getLocation() === 'global_search',
    ])
>
    @if ($banner->isVisible())
        @php
            $start_color = $banner->start_color;
            $end_color = '';

            if ($banner->background_type === 'gradient') {
                $end_color = $banner->end_color;
            } else {
                $end_color = $banner->start_color;
            }
        @endphp
        <div
            x-title="banner-component"
            x-cloak
            x-show="show"
            x-data="{
                show: true,
                storageKey: 'kenepa-banners::closed',
                init() {
                    this.hasBeenClosedByUser();
                },
                close() {
                    this.show = false;
                    let storedBanners = localStorage.getItem(this.storageKey)
                    storedBanners = JSON.parse(storedBanners)

                    if (storedBanners) {
                        storedBanners.push(this.bannerId)
                        localStorage.setItem(this.storageKey, JSON.stringify(storedBanners))
                    } else {
                        let banners = [this.bannerId]
                        localStorage.setItem(this.storageKey, JSON.stringify(banners));
                    }
                },
                hasBeenClosedByUser() {
                    let storedBanners = localStorage.getItem(this.storageKey)
                    console.log(storedBanners, this.bannerId)

                    if (storedBanners) {
                        let parsedBanners = JSON.parse(storedBanners);
                        if (parsedBanners.indexOf(this.bannerId) > -1) {
                            this.show = false;
                        }
                    }
                },
                bannerId: '{{ $banner->id }}',
            }"
            style="background-color: {{ $banner->start_color }}; background-image: linear-gradient(to right, {{ $start_color }}, {{ $end_color }}) ;color: {{ $banner->text_color ?? '#FFFFFF' }};"
            id="{{ $banner->id }}"
            @class([
               'grid grid-cols-12 pl-6 py-2 pr-8',
               'rounded-lg' => $banner->render_location !== \Filament\View\PanelsRenderHook::BODY_START
            ])>
            <div class="col-span-11 flex items-center">
                <div>
                    @if ($banner->icon)
                        <x-filament::icon
                            alias="banner::close"
                            :icon="$banner->icon"
                            style="color: {{ $banner->icon_color ?? '#FFFFFF' }}"
                            class="h-6 w-6 mr-2 text-gray-500 dark:text-gray-400 text-white"
                        />
                    @endif
                </div>
                <div>
                    {!! $banner->content !!}
                </div>
            </div>
            <div class="col-span-1 flex justify-end">
                @if ($banner->can_be_closed_by_user)
                    <x-filament::icon
                        x-on:click="close"
                        alias="banner::close"
                        icon="heroicon-m-x-mark"
                        class="h-6 w-6 text-gray-500 dark:text-gray-400 text-white cursor-pointer hover:opacity-75"
                    />
                @endif
            </div>
        </div>
    @endif
</div>
