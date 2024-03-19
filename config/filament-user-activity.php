<?php

// config for Edwink/FilamentUserActivity
return [
    'model' => \App\Models\User::class,
    'table' => [
        'name' => env('FILAMENT_USER_ACTIVITY_TABLE_NAME', 'user_activities'),
        'retention-days' => env('FILAMENT_USER_ACTIVITY_RETENTION_DAYS', 60),

        'active-users' => [
            'timeframe-selection' => [
                15 => '15 Menit',
                30 => '30 Menit',
                60 => '1 Jam',
                120 => '2 Jam',
                1440 => '24 Jam',
            ],
        ],
    ],
];
