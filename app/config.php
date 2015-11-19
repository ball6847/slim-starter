<?php

return [
    'config' => [
        'doctrine' => [
            'connection' => [
                'driver'   => 'pdo_mysql',
                'host'     => 'mysql',
                'dbname'   => 'slim_starter',
                'user'     => 'admin',
                'password' => '123456'
            ],
            'annotation_paths' => [
                BASEPATH.'models'
            ]
        ]
    ],
    'settings' => [
        'displayErrorDetails' => true
    ]
];
