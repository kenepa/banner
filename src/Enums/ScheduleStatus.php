<?php

namespace Kenepa\Banner\Enums;

enum ScheduleStatus: string implements \Filament\Support\Contracts\HasLabel
{
    case Due = 'due';
    case Visible = 'visible';
    case Fulfilled = 'fulfilled';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Due => __('banner::manager.status_due'),
            self::Visible => __('banner::manager.status_visible'),
            self::Fulfilled => __('banner::manager.status_fulfilled'),
        };
    }
}
