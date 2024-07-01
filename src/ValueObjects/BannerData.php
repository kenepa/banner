<?php

namespace Kenepa\Banner\ValueObjects;
class BannerData
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
    public static function fromArray(array $data): BannerData
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


    public function toArray(): array
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

}
