<div>
    @foreach($banners as $banner)
        @if($banner->is_active)
            <div style="background-color: {{ $banner['start_color'] }}; color:white;" id="{{ $banner->id }}"
                 class="grid grid-cols-12 pl-6 py-2 pr-8">
                <div class="col-span-11 flex items-center">
                    <div>
                        @if($banner['icon'])
                            <x-filament::icon
                                alias="banner::close"
                                :icon="$banner->icon"
                                class="h-6 w-6 mr-2 text-gray-500 dark:text-gray-400 text-white"
                            />
                        @endif
                    </div>
                    <div>
                        {!! $banner->content !!}
                    </div>
                </div>
                <div class="col-span-1 flex justify-end">
                    @if($banner->can_be_closed_by_user)
                        <x-filament::icon
                            alias="banner::close"
                            icon="heroicon-m-x-mark"
                            class="h-6 w-6 text-gray-500 dark:text-gray-400 text-white"
                        />
                    @endif
                </div>
            </div>
        @endif
    @endforeach
</div>