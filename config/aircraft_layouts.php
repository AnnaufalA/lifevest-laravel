<?php

/**
 * Aircraft Layouts Configuration
 * ===============================
 * Simple config for aircraft metadata.
 * Layout details are now hardcoded in Blade templates:
 * - resources/views/aircraft/b737.blade.php
 * - resources/views/aircraft/b777-gia.blade.php
 * - resources/views/aircraft/b777-gif.blade.php
 * - resources/views/aircraft/a330.blade.php
 */

return [
    'PK-GFD' => [
        'type' => 'B737-800',
        'icon' => '✈️',
    ],

    'PK-GIA' => [
        'type' => 'B777-300',
        'icon' => '🛫',
    ],

    'PK-GIF' => [
        'type' => 'B777-300',
        'icon' => '🛫',
    ],

    'PK-GHE' => [
        'type' => 'A330-900',
        'icon' => '🛩️',
    ],

    'PK-GPZ' => [
        'type' => 'A330-300',
        'icon' => '🛩️',
    ],
];
