<?php

require __DIR__ . "/vendor/autoload.php";

$db = include ('./config/db.php');

list(
    'driver' => $adapter,
    'host' => $host,
    'database' => $database,
    'username' => $username,
    'password' => $password,
    'charset' => $charset,
    'collation' => $collation,

) = $db['development'];

return [
    "paths" => [
        "migrations" => [
            __DIR__ . "/database/migrations"
        ],
        "seeds" => [
            __DIR__ . "/database/seeds"
        ],

    ],
    "environments" => [
        "default_migration_table" => "migrations",
        "default_database" => "development",
        "development" => [
            "adapter" => $adapter,
            "host" => $host,
            "name" => $database,
            "user" => $username,
            "pass" => $password,
            "charset" => $charset,
            "collation" => $collation,
        ]
    ]
];