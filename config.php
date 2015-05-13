<?php

return [
    'doctrine' => [
        'connection' => [
            'driver' => 'pdo_sqlite',
            'path' => APPPATH.'db.sqlite',
        ],
        'annotation_paths' => [
            APPPATH.'models'
        ]
    ]
];
