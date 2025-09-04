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
            $target = null;

            if (isset($banner->link_click_action) && $banner->link_click_action === 'clickable_banner') {

                $target = $banner->link_open_in_new_tab ? '_blank' : '_self';
            }

            if ($banner->background_type === 'gradient') {
                $end_color = $banner->end_color;
            } else {
                $end_color = $banner->start_color;
            }
        @endphp
        <div
            @if ($target)
                @click="openLink()"
                class="hover:opacity-80 cursor-pointer"
                x-data="{
                    openLink() {
                        window.open('{{ $banner->link_url }}', {{ $target ? "'$target'" : '_self' }});
                    },
                }"
            @endif
        >
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
                <div class="col-span-10 flex items-center">
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
                <div class="col-span-2 flex justify-end items-center">
                    @if (isset($banner->link_active) && $banner->link_active && $banner->link_click_action === "button")
                        <div class="flex space-x-2 hover:opacity-75 {{ $banner->can_be_closed_by_user ? 'mr-4' : '' }}">
                            <div>
                                @if ($banner->link_button_style === 'button')
                                    <div>
                                        <a
                                            href="{{ $banner->link_url }}"
                                            style="color: {{ $banner->link_text_color ?? '#FFFFFF' }}; background-color: {{ $banner->link_button_color ?? '#D97706' }};"
                                            class="hover:bg-blue-800 font-medium rounded-lg text-sm px-3 py-1 focus:outline-none whitespace-nowrap flex items-center"
                                            target="{{ $banner->link_open_in_new_tab ? '_blank' : '_self' }}"
                                        >

                                            {{ $banner->link_text }}

                                            @if ($banner->link_button_icon)
                                                <x-filament::icon
                                                    alias="banner::close"
                                                    :icon="$banner->link_button_icon"
                                                    style="color: {{ $banner->link_button_icon_color ?? '#FFFFFF' }}"
                                                    class="h-5 w-5 text-gray-500 ml-1 dark:text-gray-400 text-white"
                                                />
                                            @endif

                                        </a>
                                    </div>
                                @endif

                                @if ($banner->link_button_style === 'link')
                                    <div>
                                        <a
                                            style="color: {{ $banner->link_text_color ?? '#FFFFFF' }};"
                                            href="{{ $banner->link_url }}"
                                            class="underline font-bold whitespace-nowrap flex items-center"
                                            target="{{ $banner->link_open_in_new_tab ? '_blank' : '_self' }}"
                                        >

                                            {{ $banner->link_text }}

                                            @if ($banner->link_button_icon)
                                                <x-filament::icon
                                                    alias="banner::close"
                                                    :icon="$banner->link_button_icon"
                                                    style="color: {{ $banner->link_button_icon_color ?? '#FFFFFF' }}"
                                                    class="h-5 w-5 text-gray-500 ml-1 dark:text-gray-400 text-white"
                                                />
                                            @endif
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                    @if ($banner->can_be_closed_by_user)
                        <x-filament::icon
                            @click.stop="close"
                            alias="banner::close"
                            icon="heroicon-m-x-mark"
                            class="h-6 w-6 text-gray-500 dark:text-gray-400 text-white cursor-pointer hover:opacity-75"
                        />
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
