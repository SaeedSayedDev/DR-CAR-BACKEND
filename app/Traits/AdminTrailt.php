<?php

namespace App\Traits;

class AdminTrailt
{
    public static  $roles = [
        ['name' => 'admin'],
        ['name' => 'customer'],
        ['name' => 'winch'],
        ['name' => 'garage']
    ];


    public static $categories = [
        [
            'name' => [
                'en' => 'Maintenance and Repairs',
                'ar' => 'الصيانة والإصلاحات',
            ],
            'desc' => [
                'en' => 'Services related to regular maintenance and repairs of vehicles.',
                'ar' => 'خدمات تتعلق بالصيانة الدورية وإصلاحات المركبات.',
            ],
        ],
        [
            'name' => [
                'en' => 'Body Work and Painting',
                'ar' => 'أعمال الهيكل والدهان',
            ],
            'desc' => [
                'en' => 'Services related to body repairs and vehicle painting.',
                'ar' => 'خدمات تتعلق بإصلاحات الهيكل ودهان المركبات.',
            ],
        ],
        [
            'name' => [
                'en' => 'Tire and Wheel Services',
                'ar' => 'خدمات الإطارات والعجلات',
            ],
            'desc' => [
                'en' => 'Services related to tire replacement, wheel alignment, and balancing.',
                'ar' => 'خدمات تتعلق بتغيير الإطارات وضبط العجلات والتوازن.',
            ],
        ],
    ];


    public static $items = [
        [
            'name' => [
                'en' => 'Engine Oil Change',
                'ar' => 'تغيير زيت المحرك',
            ],
            'desc' => [
                'en' => 'Professional engine oil change service using high-quality oil.',
                'ar' => 'خدمة تغيير زيت المحرك بشكل احترافي باستخدام زيت عالي الجودة.',
            ],
            'category_id' => 1, // Category ID for Maintenance and Repairs
        ],
        [
            'name' => [
                'en' => 'Brake Pad Replacement',
                'ar' => 'استبدال العجلات',
            ],
            'desc' => [
                'en' => 'Replace worn-out brake pads with new ones for improved braking performance.',
                'ar' => 'استبدال العجلات المتآكلة بأخرى جديدة لتحسين أداء الفرامل.',
            ],
            'category_id' => 1, // Category ID for Maintenance and Repairs
        ],
        [
            'name' => [
                'en' => 'Wheel Alignment',
                'ar' => 'ضبط العجلات',
            ],
            'desc' => [
                'en' => 'Precise wheel alignment service to ensure optimal tire wear and vehicle stability.',
                'ar' => 'خدمة ضبط العجلات بدقة لضمان ارتداد مثالي للإطارات وثبات المركبة.',
            ],
            'category_id' => 3, // Category ID for Tire and Wheel Services
        ],
        [
            'name' => [
                'en' => 'Paintless Dent Repair',
                'ar' => 'إصلاح الخدوش بدون دهان',
            ],
            'desc' => [
                'en' => 'Expert dent repair without the need for repainting, preserving the original finish.',
                'ar' => 'إصلاح الخدوش بشكل احترافي دون الحاجة لإعادة الدهان، مما يحافظ على اللمسة الأصلية.',
            ],
            'category_id' => 2, // Category ID for Body Work and Painting
        ],
        [
            'name' => [
                'en' => 'Tire Rotation',
                'ar' => 'دوران الإطارات',
            ],
            'desc' => [
                'en' => 'Regular tire rotation service for even tire wear and extended tire lifespan.',
                'ar' => 'خدمة دوران الإطارات الدورية للحفاظ على ارتداد متساوي للإطارات وزيادة عمر الإطار.',
            ],
            'category_id' => 3, // Category ID for Tire and Wheel Services
        ],
        [
            'name' => [
                'en' => 'Car Battery Replacement',
                'ar' => 'استبدال بطارية السيارة',
            ],
            'desc' => [
                'en' => 'Replace the old car battery with a new one to ensure reliable starting power.',
                'ar' => 'استبدال بطارية السيارة القديمة بأخرى جديدة لضمان بداية موثوقة.',
            ],
            'category_id' => 1, // Category ID for Maintenance and Repairs
        ],
        [
            'name' => [
                'en' => 'Air Conditioning Service',
                'ar' => 'خدمة التكييف',
            ],
            'desc' => [
                'en' => 'Professional air conditioning service including refrigerant recharge and system inspection.',
                'ar' => 'خدمة تكييف محترفة تشمل إعادة شحن المبرد وفحص النظام.',
            ],
            'category_id' => 1, // Category ID for Maintenance and Repairs
        ],
        [
            'name' => [
                'en' => 'Headlight Restoration',
                'ar' => 'استعادة الأضواء الأمامية',
            ],
            'desc' => [
                'en' => 'Restore cloudy or yellowed headlights for improved visibility and safety.',
                'ar' => 'استعادة الأضواء الأمامية المعتمة أو المصفرة لتحسين الرؤية والسلامة.',
            ],
            'category_id' => 2, // Category ID for Body Work and Painting
        ],
        [
            'name' => [
                'en' => 'Spark Plug Replacement',
                'ar' => 'استبدال شمعات الإشعال',
            ],
            'desc' => [
                'en' => 'Replace worn-out spark plugs to ensure efficient combustion and engine performance.',
                'ar' => 'استبدال شمعات الإشعال المتآكلة لضمان احتراق فعال وأداء المحرك.',
            ],
            'category_id' => 1, // Category ID for Maintenance and Repairs
        ],
    ];






    public static $paymentMethods = [
        [
            'payment_type' => 1,
            'name' => 'Paypal',
            'logo' => 'paypal.jpg',
            'default' => true,
        ],
        [
            'payment_type' => 2,
            'name' => 'Stripe',
            'logo' => 'stripe.jpg',
        ],
    ];




    public static $optionGroups = [

        ['name' => 'Size'],
        ['name' => 'Area'],
        ['name' => 'Surface'],

    ];



    public static $taxes = [
        [
            'name' => 'tax 20',
            'value' => '20',
            'type' => 'percent',
        ],
        [
            'name' => 'tax 10',
            'value' => '10',
            'type' => 'percent',
        ],
        [
            'name' => 'maintenance',
            'value' => '2',
            'type' => 'fixed',
        ],
        [
            'name' => 'tools fee',
            'value' => '5',
            'type' => 'fixed',
        ],
    ];

    public static $statusOrders = [
        [
            'name' => 'Received',
        ],
        [
            'name' => 'Accepted',
        ],
        [
            'name' => 'On the way',
        ],
        [
            'name' => 'Ready',
        ],
        [
            'name' => 'in progress',
        ],
        [
            'name' => 'Done',
        ],
        [
            'name' => 'Failed',
        ],
    ];
}
