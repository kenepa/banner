<div>
    @foreach($banners as $banner)
        @if($banner->is_active)
            @php
                $start_color = $banner->start_color;
                $end_color = '';

                if ($banner->background_type === 'gradient') {
                    $end_color = $banner->end_color;
                } else {
                    $end_color = $banner->start_color;
                }
            @endphp
            <div style="background-color: {{ $banner->start_color }}; background-image: linear-gradient(to right, {{ $start_color }}, {{ $end_color }}) ;color:white;" id="{{ $banner->id }}"
                 class="grid grid-cols-12 pl-6 py-2 pr-8">
                <div class="col-span-11 flex items-center">
                    <div>
                        @if($banner->icon)
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
