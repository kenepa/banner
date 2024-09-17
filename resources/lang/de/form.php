<?php

return [
    'tabs' => [
        'general' => 'Allgemein',
        'styling' => 'Styling',
        'scheduling' => 'Planung',
    ],
    'fields' => [
        'id' => 'ID',
        'name' => 'Name',
        'content' => 'Inhalt',
        'render_location' => 'Anzeigeposition',
        'render_location_help' => 'Mit der Anzeigeposition kannst du festlegen, wo ein Banner auf der Seite angezeigt wird. In Kombination mit Scopes wird dies zu einem leistungsstarken Tool, um zu steuern, wo und wann deine Banner angezeigt werden. Du kannst Banner im Header, in der Seitenleiste oder an anderen strategischen Positionen platzieren, um deren Sichtbarkeit und Wirkung zu maximieren.',
        'render_location_options' => [
            'panel' => [
                'header' => 'Header',
                'page_start' => 'Anfang der Seite',
                'page_end' => 'Ende der Seite',
            ],
            'authentication' => [
                'login_form_before' => 'Vor dem Login-Formular',
                'login_form_after' => 'Nach dem Login-Formular',
                'password_reset_form_before' => 'Vor dem Passwort-Zurücksetzen-Formular',
                'password_reset_form_after' => 'Nach dem Passwort-Zurücksetzen-Formular',
                'register_form_before' => 'Vor dem Registrierungsformular',
                'register_form_after' => 'Nach dem Registrierungsformular',
            ],
            'global_search' => [
                'before' => 'Vor der globalen Suche',
                'after' => 'Nach der globalen Suche',
            ],
            'page_widgets' => [
                'header_before' => 'Vor den Header-Widgets',
                'header_after' => 'Nach den Header-Widgets',
                'footer_before' => 'Vor den Footer-Widgets',
                'footer_after' => 'Nach den Footer-Widgets',
            ],
            'sidebar' => [
                'nav_start' => 'Vor der Seitenleisten-Navigation',
                'nav_end' => 'Nach der Seitenleisten-Navigation',
            ],
            'resource_table' => [
                'before' => 'Vor der Ressourcentabelle',
                'after' => 'Nach der Ressourcentabelle',
            ],
        ],
        'scope' => 'Scope',
        'scope_help' => 'Mit der Scope-Funktion kannst du steuern, wo dein Banner angezeigt wird. Du kannst dein Banner auf bestimmte Seiten oder gesamte Ressourcen ausrichten, um sicherzustellen, dass es der richtigen Zielgruppe zur richtigen Zeit angezeigt wird.',
        'options' => 'Optionen',
        'can_be_closed_by_user' => 'Banner kann vom Benutzer geschlossen werden',
        'can_truncate_message' => 'Inhalt des Banners wird gekürzt',
        'is_active' => 'Ist aktiv',
        'text_color' => 'Textfarbe',
        'icon' => 'Icon',
        'icon_color' => 'Iconfarbe',
        'background' => 'Hintergrund',
        'background_type' => 'Hintergrundtyp',
        'background_type_solid' => 'Einfarbig',
        'background_type_gradient' => 'Verlauf',
        'start_color' => 'Startfarbe',
        'end_color' => 'Endfarbe',
        'start_time' => 'Startzeit',
        'start_time_reset' => 'Startzeit zurücksetzen',
        'end_time' => 'Endzeit',
        'end_time_reset' => 'Endzeit zurücksetzen',
    ],
    'badges' => [
        'scheduling_status' => [
            'active' => 'Aktiv',
            'scheduled' => 'Geplant',
            'expired' => 'Abgelaufen',
        ],
    ],
    'actions' => [
        'help' => 'Hilfe',
        'reset' => 'Zurücksetzen',
    ],
];
