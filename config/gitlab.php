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
);

