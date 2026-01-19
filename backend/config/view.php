<?php

declare(strict_types=1);

return [
    'paths' => [
        resource_path('views'),
        base_path('src/Core/Presentation/View'),
        base_path('src/Example/Presentation/View'),
        base_path('src/Auth/Presentation/View'),
    ],

    'compiled' => env('VIEW_COMPILED_PATH', realpath(storage_path('framework/views'))),
];
