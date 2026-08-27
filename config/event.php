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
    ],

];
