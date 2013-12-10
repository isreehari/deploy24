<?php
return array(
	'deploy24.com' => array(
		'branch' => 'master',
		'remote' => 'origin',
		'path' => '/var/www/deploy24.com/'
	),
    'chatter.deploy24.com' => array(
        'branch' => 'master',
        'remote' => 'origin',
        'path' => '/var/www/chatter.deploy24.com/',
        'commands' => array('composer update', 'composer dump-autoload')
    ),
    'rusantic.com' => array(
        'branch' => 'master',
        'remote' => 'origin',
        'path' => '/var/www/rusantic.deploy24.com/',
        'commands' => array('composer update', 'composer dump-autoload')
    ),
    'greeting.av.ru' => array(
        'branch' => 'master',
        'remote' => 'origin',
        'path' => '/var/www/greetingav.deploy24.com/'
    ),
);

