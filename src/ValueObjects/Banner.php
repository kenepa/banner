<?php

namespace Kenepa\Banner\ValueObjects;

use Livewire\Wireable;

class Banner implements Wireable
{
    public function __construct(
        public string $id,
        public string $name,
        public string $content,
        public string $is_active,
        public ?string $active_since,
        public ?string $icon,
        public string $background_type,
        public string $start_color,
        public ?string $end_color,
        public ?string $start_time,
        public ?string $end_time,
        public bool $can_be_closed_by_user,
    ) {}

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

    public function toLivewire()
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
}
