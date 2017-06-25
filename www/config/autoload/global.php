<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host'    => '127.0.0.1',
                    'port'    => '3306',
                    'dbname'  => 'ARGIVE',
                    'charset' => 'utf8',
                )
            ),
            'orm_development' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host'    => '127.0.0.1',
                    'port'    => '3306',
                    'dbname'  => 'ARGIVE_DEV',
                    'charset' => 'utf8',
                )
            )
        ),
        'entitymanager' => array(
            'orm_development' => array(
                'connection' => 'orm_development',
            )
        ),
    ),
    'argive' => array(
        'production' => array(
            'reviews' => array(
                'upload_dir' => '/home/argive/prod/data-server/www/uploads/production/reviews',
                'completed_dir' => '/home/argive/prod/data-server/www/uploads/production/reviews/completed',
                'cleanup_dir' => true,
            ),
        ),
        'development' => array(
            'reviews' => array(
                'upload_dir' => '/home/argive/prod/data-server/www/uploads/development/reviews',
                'completed_dir' => '/home/argive/prod/data-server/www/uploads/development/reviews/completed',
                'cleanup_dir' => true,
            ),
        ),
    )
);
