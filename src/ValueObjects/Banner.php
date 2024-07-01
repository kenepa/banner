<?php

namespace Kenepa\Banner\ValueObjects;

use Illuminate\Support\Carbon;
use Livewire\Wireable;

class Banner implements Wireable
{
    public function __construct(
        public string $id,
        public string $name,
        public string $content,
        public string $is_active,
        public string|null $active_since,
        public string|null $icon,
        public string $background_type,
        public string $start_color,
        public string|null $end_color,
        public string|null $start_time,
        public string|null $end_time,
        public bool $can_be_closed_by_user,
    )
    {
    }

    // Todo: add defaults to all
    public static function fromArray(array $data): Banner
    {
        return new static(
            $data['id'],
            $data['name'],
            $data['content'],
            $data['is_active'],
            $data['active_since'] ?? null,
            $data['icon'],
            $data['background_type'],
            $data['start_color'],
            $data['end_color'] ?? null,
            $data['start_time'],
            $data['end_time'],
            $data['can_be_closed_by_user'],
        );
    }

    public function toLivewire(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'content' => $this->content,
            'is_active' => $this->is_active,
            'active_since' => $this->active_since,
            'icon' => $this->icon,
            'background_type' => $this->background_type,
            'start_color' => $this->start_color,
            'end_color' => $this->end_color,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'can_be_closed_by_user' => $this->can_be_closed_by_user,
        ];
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
        );
    }

    public function isVisible(): bool
    {
        if ($this->is_active && $this->canViewBasedOnSchedule()) {
            return true;
        }

        return false;
    }

    public function canViewBasedOnSchedule(): bool
    {
        $start_time = Carbon::parse($this->start_time);
        $end_time = Carbon::parse($this->end_time);

        if ($start_time < now() && now() < $end_time) {
            return true;
        }

        return false;
    }

    public function isScheduled(): bool
    {

    }
}
