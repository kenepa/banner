<?php

namespace Kenepa\Banner;

use Filament\View\PanelsRenderHook;
use Illuminate\Support\Carbon;
use Kenepa\Banner\ValueObjects\BannerData;
use Livewire\Wireable;

class Banner implements Wireable
{
    public function __construct(
        public string $id,
        public string $name,
        public string $content,
        public bool $is_active,
        public ?string $active_since,
        public ?string $icon,
        public string $background_type,
        public string $start_color,
        public ?string $end_color,
        public ?string $start_time,
        public ?string $end_time,
        public bool $can_be_closed_by_user,
        public ?string $text_color,
        public ?string $icon_color,
        public ?string $render_location,
        public ?array $scope,
        public ?string $link_url,
        public ?string $link_text,
        public ?string $link_click_action,
        public ?string $link_button_style,
        public ?string $link_button_color,
        public ?string $link_text_color,
        public ?string $link_active,
        public ?bool $link_open_in_new_tab,
        public ?string $link_button_icon,
        public ?string $link_button_icon_color,
    ) {}

    public static function fromData(BannerData $data): static
    {
        return new static(
            $data->id,
            $data->name,
            $data->content,
            $data->is_active,
            $data->active_since,
            $data->icon,
            $data->background_type,
            $data->start_color,
            $data->end_color,
            $data->start_time,
            $data->end_time,
            $data->can_be_closed_by_user,
            $data->text_color,
            $data->icon_color,
            $data->render_location,
            $data->scope,
            $data->link_url,
            $data->link_text,
            $data->link_click_action,
            $data->link_button_style,
            $data->link_button_color,
            $data->link_text_color,
            $data->link_active,
            $data->link_open_in_new_tab,
            $data->link_button_icon,
            $data->link_button_icon_color,
        );
    }

    public static function fromLivewire($value)
    {
        return new static(
            $value['id'],
            $value['name'],
            $value['content'],
            $value['is_active'],
            $value['active_since'],
            $value['icon'],
            $value['background_type'],
            $value['start_color'],
            $value['end_color'],
            $value['start_time'],
            $value['end_time'],
            $value['can_be_closed_by_user'],
            $value['text_color'],
            $value['icon_color'],
            $value['render_location'],
            $value['scope'],
            $value['link_url'],
            $value['link_text'],
            $value['link_click_action'],
            $value['link_button_style'],
            $value['link_button_color'],
            $value['link_text_color'],
            $value['link_active'],
            $value['link_open_in_new_tab'],
            $value['link_button_icon'],
            $value['link_button_icon_color'],
        );
    }

    public function toLivewire(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'content' => $this->content,
            'is_active' => $this->is_active,
            'active_since' => $this->active_since ?? null,
            'icon' => $this->icon ?? null,
            'background_type' => $this->background_type,
            'start_color' => $this->start_color,
            'end_color' => $this->end_color ?? null,
            'start_time' => $this->start_time ?? null,
            'end_time' => $this->end_time ?? null,
            'can_be_closed_by_user' => $this->can_be_closed_by_user,
            'text_color' => $this->text_color ?? null,
            'icon_color' => $this->icon_color ?? null,
            'render_location' => $this->render_location ?? null,
            'scope' => $this->scope ?? null,
            'link_url' => $this->link_url ?? null,
            'link_text' => $this->link_text ?? null,
            'link_click_action' => $this->link_click_action ?? null,
            'link_button_style' => $this->link_button_style ?? null,
            'link_button_color' => $this->link_button_color ?? null,
            'link_text_color' => $this->link_text_color ?? null,
            'link_active' => $this->link_active ?? null,
            'link_open_in_new_tab' => $this->link_open_in_new_tab ?? null,
            'link_button_icon' => $this->link_button_icon ?? null,
            'link_button_icon_color' => $this->link_button_icon_color ?? null,
        ];
    }

    public function isVisible(): bool
    {
        if ($this->is_active && $this->canViewBasedOnSchedule()) {
            return true;
        }

        return false;
    }

    // TODO write: test
    public function canViewBasedOnSchedule(): bool
    {
        $start_time = Carbon::parse($this->start_time);
        $end_time = Carbon::parse($this->end_time);

        if ($this->hasNoScheduleSet()) {
            return true;
        }

        if ($this->hasOnlyEndTime() && now() < $end_time) {
            return true;
        }

        if ($this->hasOnlyStartTime() && now() > $start_time) {
            return true;
        }

        if ($this->hasSchedule() & $start_time < now() && now() < $end_time) {
            return true;
        }

        return false;
    }

    // TODO: Extract funcs to trait
    public function hasNoScheduleSet(): bool
    {
        return is_null($this->start_time) && is_null($this->end_time);
    }

    public function hasOnlyStartTime(): bool
    {
        return ! is_null($this->start_time) && is_null($this->end_time);
    }

    public function hasOnlyEndTime(): bool
    {
        return ! is_null($this->end_time) && is_null($this->start_time);
    }

    public function hasSchedule(): bool
    {
        return ! is_null($this->start_time) && ! is_null($this->end_time);
    }

    public function isScheduled(): bool {}

    public function getLocation(): string
    {
        return match ($this->render_location) {
            PanelsRenderHook::BODY_START => 'body',
            PanelsRenderHook::PAGE_START, PanelsRenderHook::PAGE_END => 'panel',
            PanelsRenderHook::SIDEBAR_NAV_START, PanelsRenderHook::SIDEBAR_NAV_END => 'nav',
            PanelsRenderHook::GLOBAL_SEARCH_BEFORE, PanelsRenderHook::GLOBAL_SEARCH_AFTER => 'global_search',
            default => ''
        };
    }
}
