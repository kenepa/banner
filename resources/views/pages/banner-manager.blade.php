<x-filament-panels::page>
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-full xl:col-span-4">
            <x-filament::section>

                <x-slot name="heading">
                    {{ $this->createNewBanner }}
                </x-slot>

                <x-slot name="headerEnd">
                    <x-filament::dropdown placement="bottom-end">
                        <x-slot name="trigger">
                            <x-filament::icon-button
                                icon="heroicon-m-ellipsis-vertical"
                                label="Extra option"
                            />
                        </x-slot>

                        <x-filament::dropdown.list>

                            <x-filament::dropdown.list.item
                                icon="heroicon-m-power"
                                wire:click="enableAllBanners">
                                {{ __('banner::manager.enable_all_banners') }}
                            </x-filament::dropdown.list.item>

                            <x-filament::dropdown.list.item
                                icon="heroicon-m-no-symbol"
                                wire:click="disableAllBanners">
                                {{ __('banner::manager.disable_all_banners') }}
                            </x-filament::dropdown.list.item>

                        </x-filament::dropdown.list>
                    </x-filament::dropdown>
                </x-slot>

                @if ($banners)
                    <div class="space-y-2 font-medium text-sm h-64 xl:h-auto overflow-y-scroll">
                        @foreach ($banners as $banner)
                            <div
                                wire:click="selectBanner('{{ $banner->id }}')"
                                @class([
                                    'rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition dark:active:bg-gray-700 active:bg-gray-200 active:shadow-inner hover:transition-all dark:ring-white/10 px-4 py-4 select-none cursor-pointer',
                                    'bg-gray-100 dark:bg-gray-800' => $this->isBannerActive($banner->id) ?? false
                                ])
                            >
                                <h1>{{ $banner->name }}</h1>
                                <div class="flex item-center mt-1">
                                    <div
                                        @class([
                                            'h-4 w-4 rounded-full border-4  mr-1',
                                            'bg-green-400 border-green-200 dark:border-green-800' => $banner->is_active,
                                            'bg-gray-400 border-gray-200 dark:border-gray-700' => ! $banner->is_active
                                        ])
                                    ></div>
                                    <div class="text-xs text-gray-400">
                                        @if ($banner->is_active)
                                           {{ __('banner::manager.active_since') }} · {{ \Carbon\Carbon::parse($banner->active_since)->diffForHumans() }}
                                        @else
                                            {{ __('banner::manager.inactive') }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <x-banner::manager.banner-list-empty-state/>
                @endif

            </x-filament::section>
        </div>

        <div class="col-span-full xl:col-span-8">
            @if ($selectedBanner)
                <x-filament::section>

                    <form wire:submit="updateBanner">
                        {{ $this->form }}

                        <div class="flex justify-between items-center">
                            <x-filament::button type="submit" class="mt-4">
                                {{ __('banner::manager.save') }}
                            </x-filament::button>

                            {{ $this->deleteBanner }}
                        </div>
                    </form>

                </x-filament::section>
            @else
                <div class="h-64 bg-gray-100 dark:bg-gray-900 shadow-inner rounded-lg flex items-center justify-center">
                    <div class="text-center select-none">
                        <div
                            class="bg-gray-300 dark:bg-gray-700 h-16 w-16 mx-auto p-2 rounded-full flex items-center justify-center mb-3">
                            <x-filament::icon
                                icon="heroicon-m-megaphone"
                                class="h-16 w-16 p-1 text-gray-400 dark:text-gray-400"
                            />
                        </div>
                        <h1 class="font-bold text-xl text-gray-400 dark:text-white">{{ __('banner::manager.banner_edit_empty_state_title') }}</h1>
                        <p class="text-gray-400">{{ __('banner::manager.banner_edit_empty_state_description') }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-filament-panels::page>
