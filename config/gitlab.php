<?php
return array(
    'golubev.eu' => array(
        'branch' => 'master',
        'remote' => 'origin',
        'path' => '/var/www/golubev.eu/'
    ),
    'deploy24.com' => array(
        'branch' => 'master',
        'remote' => 'origin',
        'path' => '/var/www/deploy24.com/'
    ),
    'chatter.deploy24.com' => array(
        'branch' => 'master',
        'remote' => 'origin',
        'path' => '/var/www/chatter.deploy24.com/',
        'commands' => array(
            'composer update --no-dev',
            'composer dump-autoload',
        )
    ),
    'rusantic.com' => array(
        'branch' => 'master',
        'remote' => 'origin',
        'path' => '/var/www/rusantic.deploy24.com/',
        'commands' => array(
            'composer update --no-dev',
            'composer dump-autoload',
        )
    ),
    'greeting.av.ru' => array(
        'branch' => 'master',
        'remote' => 'origin',
        'path' => '/var/www/greetingav.deploy24.com/',
        'submodule' => true
    ),
    'zakonum.ru' => array(
        'branch' => 'master',
        'remote' => 'origin',
        'path' => '/var/www/zakonum.deploy24.com/',
        'commands' => array(
            'composer update --no-dev',
            'php app/console doctrine:schema:update --force',
            'php app/console doctrine:fixtures:load',
            'php app/console assets:install',
        )
    ),
    'pzz.by' => array(
        'branch' => 'master',
        'remote' => 'origin',
        'path' => '/var/www/pzz.deploy24.com/',
        'commands' => array(
            'composer update --no-dev --prefer-dist',
            'php artisan migrate'
        )
    ),
);
