<?php

return [

    'dbal' => [
        'default_connection' => 'default',
        'connections'        => [
            'default'  => [
                'driver'   => '%database_driver%',
                'host'     => '%database_host%',
                'port'     => '%database_port%',
                'dbname'   => '%database_name%',
                'user'     => '%database_user%',
                'password' => '%database_password%',
                'charset'  => 'UTF8',
            ],
            'customer' => [
                'driver'   => '%database_driver2%',
                'host'     => '%database_host2%',
                'port'     => '%database_port2%',
                'dbname'   => '%database_name2%',
                'user'     => '%database_user2%',
                'password' => '%database_password2%',
                'charset'  => 'UTF8',
            ],
        ],
    ],
    'orm'  => [
        'default_entity_manager' => 'default',
        'entity_managers'        => [
            'default'  => [
                'connection' => 'default',
                'mappings'   => [
                    'AppBundle'       => null,
                    'AcmeStoreBundle' => null,
                ],
            ],
            'customer' => [
                'connection' => 'customer',
                'mappings'   => [
                    'AcmeCustomerBundle' => null,
                ],
            ],
        ],
    ],
];
