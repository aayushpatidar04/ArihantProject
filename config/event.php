<?php

return [
    'event_name' => 'ArihantPLUS AI & Algo Conclave 2026',
    'event_date' => '2026-09-05',
    'event_time' => '10:00 AM - 5:00 PM',
    'venue' => 'Mariott Hotel, Indore',
    'existing_client_price' => 399,
    'new_user_price' => 599,
    'currency' => 'INR',
    'venue_pin' => env('VENUE_PIN'),

    // Admin emails allowed to access dashboard
    'admin_emails' => [
        env('ADMIN_EMAIL', 'admin@event.arihantcapital.com'),
        'dipak.rout@arihantcapital.com',
        'varun.dave@arihantcapital.com',
        'vinay.jain@arihantcapital.com',
        'vedant.sharma@arihantcapital.com',
        'ayushb190458@gmail.com',
        'sales@intouchsoftware.co.in',
    ],

    // Super admin emails — can manage other admin permissions
    'super_admin_emails' => [
        'dipak.rout@arihantcapital.com',
        'varun.dave@arihantcapital.com',
        'ayushb190458@gmail.com',
    ],

    'promo' => [
        'code' => env('EVENT_PROMO_CODE', 'IIT200'),
        'limit' => (int) env('EVENT_PROMO_LIMIT', 30),
        'amount' => (int) env('EVENT_PROMO_AMOUNT', 200),
    ],

    // Quiz Configuration
    'quiz' => [
        'points_per_correct' => 10,
        'max_questions' => 50,
        'max_participants' => 1000,
        'pin_length' => 6,
        'polling_interval_ms' => 3000,
        'quiz_types' => [
            'reasoning' => 'Reasoning Quiz',
            'aptitude' => 'Aptitude Quiz',
            'gk' => 'GK Quiz',
        ],
    ],
];
