<?php

return [
    'tabs' => [
        'general' => 'عام',
        'styling' => 'الاستايل',
        'scheduling' => 'جدولة',
    ],
    'fields' => [
        'id' => 'مسلسل',
        'name' => 'الاسم',
        'content' => 'المحتوى',
        'render_location' => 'موقع العرض',
        'render_location_help' => 'اختر موقع العرض الذي تريد عرض البانر فيه. يمكنك اختيار موقع عرض واحد أو أكثر.',
        'render_location_options' => [
            'panel' => [
                'header' => 'العنوان',
                'page_start' => 'بداية الصفحة',
                'page_end' => 'نهاية الصفحة',
            ],
            'authentication' => [
                'login_form_before' => 'قبل نموذج تسجيل الدخول',
                'login_form_after' => 'بعد نموذج تسجيل الدخول',
                'password_reset_form_before' => 'قبل نموذج إعادة تعيين كلمة المرور',
                'password_reset_form_after' => 'بعد نموذج إعادة تعيين كلمة المرور',
                'register_form_before' => 'قبل نموذج التسجيل',
                'register_form_after' => 'بعد نموذج التسجيل',
            ],
            'global_search' => [
                'before' => 'قبل البحث العام',
                'after' => 'بعد البحث العام',
            ],
            'page_widgets' => [
                'header_before' => 'قبل عناصر العنوان',
                'header_after' => 'بعد عناصر العنوان',
                'footer_before' => 'قبل عناصر التذييل',
                'footer_after' => 'بعد عناصر التذييل',
            ],
            'sidebar' => [
                'nav_start' => 'قبل القائمة الجانبية',
                'nav_end' => 'بعد القائمة الجانبية',
            ],
            'resource_table' => [
                'before' => 'قبل جدول الموارد',
                'after' => 'بعد جدول الموارد',
            ],
        ],
        'scope' => 'النطاق',
        'scope_help' => 'اختر النطاق الذي تريد عرض البانر فيه. يمكنك اختيار نطاق واحد أو أكثر.',
        'options' => 'الخيارات',
        'can_be_closed_by_user' => 'يمكن للمستخدم إغلاق البانر',
        'can_truncate_message' => 'يمكن قص الرسالة',
        'is_active' => 'نشط',
        'text_color' => 'لون النص',
        'icon' => 'الأيقونة',
        'icon_color' => 'لون الأيقونة',
        'background' => 'الخلفية',
        'background_type' => 'نوع الخلفية',
        'background_type_solid' => 'صلب',
        'background_type_gradient' => 'تدرج',
        'start_color' => 'لون البداية',
        'end_color' => 'لون النهاية',
        'start_time' => 'وقت البداية',
        'start_time_reset' => 'إعادة تعيين وقت البداية',
        'end_time' => 'وقت النهاية',
        'end_time_reset' => 'إعادة تعيين وقت النهاية',
    ],
    'badges' => [
        'scheduling_status' => [
            'active' => 'مفعل',
            'scheduled' => 'مجدول',
            'expired' => 'منتهي',
        ],
    ],
    'actions' => [
        'help' => 'مساعدة',
        'reset' => 'إعادة تعيين',
    ],
];
