<?php

return [
    'tabs' => [
        'general' => 'General',
        'styling' => 'Styling',
        'scheduling' => 'Scheduling',
    ],
    'fields' => [
        'id' => 'ID',
        'name' => 'Name',
        'content' => 'Content',
        'render_location' => 'Render Location',
        'render_location_help' => 'With render location, you can select where a banner is rendered on the page. In combination with scopes, this becomes a powerful tool to manage where and when your banners are displayed. You can choose to render banners in the header, sidebar, or other strategic locations to maximize their visibility and impact.',
        'render_location_options' => [
            'panel' => [
                'header' => 'Header',
                'page_start' => 'Start of page',
                'page_end' => 'End of page',
            ],
            'authentication' => [
                'login_form_before' => 'Before login Form',
                'login_form_after' => 'After login form',
                'password_reset_form_before' => 'Before reset password form',
                'password_reset_form_after' => 'After reset password form',
                'register_form_before' => 'Before register form',
                'register_form_after' => 'After register form',
            ],
            'global_search' => [
                'before' => 'Before global search',
                'after' => 'After global search',
            ],
            'page_widgets' => [
                'header_before' => 'Before header widgets',
                'header_after' => 'After header widgets',
                'footer_before' => 'Before footer widgets',
                'footer_after' => 'After footer widgets',
            ],
            'sidebar' => [
                'nav_start' => 'Before sidebar navigation',
                'nav_end' => 'After sidebar navigation',
            ],
            'resource_table' => [
                'before' => 'Before resource table',
                'after' => 'After resource table',
            ],
        ],
        'scope' => 'Scope',
        'scope_help' => 'With scoping, you can control where your banner is displayed. You can target your banner to specific pages or entire resources, ensuring it is shown to the right audience at the right time.',
        'options' => 'Options',
        'can_be_closed_by_user' => 'Banner can be closed by user',
        'can_truncate_message' => 'Truncates the content of banner',
        'is_active' => 'Is Active',
        'text_color' => 'Text Color',
        'icon' => 'Icon',
        'icon_color' => 'Icon Color',
        'background' => 'Background',
        'background_type' => 'Background Type',
        'background_type_solid' => 'Solid',
        'background_type_gradient' => 'Gradient',
        'start_color' => 'Start Color',
        'end_color' => 'End Color',
        'start_time' => 'Start Time',
        'start_time_reset' => 'Reset Start Time',
        'end_time' => 'End Time',
        'end_time_reset' => 'Reset End Time',
    ],
    'badges' => [
        'scheduling_status' => [
            'active' => 'Active',
            'scheduled' => 'Scheduled',
            'expired' => 'Expired',
        ],
    ],
    'actions' => [
        'help' => 'Help',
        'reset' => 'Reset',
    ],
];
