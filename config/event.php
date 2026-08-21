<?php

return [
    'event_name' => 'ArihantPLUS AI & Algo Conclave 2026',
    'event_date' => '2026-09-05',
    'event_time' => '10:00 AM - 5:00 PM',
    'venue' => 'Labh Mandapam, Indore',
    'existing_client_price' => 299,
    'new_user_price' => 599,
    'currency' => 'INR',
    'venue_pin' => env('VENUE_PIN'),

    // Admin emails allowed to access dashboard
    'admin_emails' => [
        env('ADMIN_EMAIL', 'admin@arihantcapital.com'),
    ],

    // Quiz correct answers (question_id => answer)
    'quiz_answers' => [
        'q1' => 'a',
        'q2' => 'b',
        'q3' => 'c',
        'q4' => 'd',
        'q5' => 'a',
    ],
];
