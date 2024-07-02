<?php

namespace Kenepa\Banner\ValueObjects;

class BannerData
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
    ) {}

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
            $data['text_color'] ?? null,
            $data['icon_color'] ?? null,
            $data['render_location'] ?? null,
            $data['scope'] ?? null,
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
            'text_color' => $this->text_color,
            'icon_color' => $this->icon_color,
            'render_location' => $this->render_location,
            'scope' => $this->scope,
        ];
    }
}
