<?php
require 'vendor/autoload.php';

return [
    'paths' => [
        'migrations' => 'data/migrations',
    ],
    'environments' => [
        'default_database' => 'development',
        'development' => [
            'adapter' => 'mysql',
            'host' => 'trivio_mysql_1',
            'name' => 'database',
            'user' => 'user',
            'pass' => 'password'
        ]
    ]
];
