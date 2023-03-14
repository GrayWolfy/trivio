<?php

/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

use Laminas\I18n\Translator\Loader\PhpArray;
use Laminas\I18n\Translator\Translator;

return [
    'translator' => [
        'locale' => 'en_US', // default locale
        'translation_file_patterns' => [
            [
                'type' => PhpArray::class,
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.php',
                'text_domain' => 'default', // default text domain
            ],
        ],
    ],
    'db' => [
        'driver' => 'Pdo',
        'dsn' => 'mysql:dbname=database;host=trivio_mysql_1',
        'username' => 'user',
        'password' => 'password',
    ],
];