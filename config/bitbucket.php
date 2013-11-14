<?php
return array(
	'deploy24.com' => array(
		'branch' => 'master',
		'remote' => 'origin',
		'path' => '/var/www/deploy24.com/'
	),
	'rusantic.com' => array(
		'branch' => 'master',
		'remote' => 'origin',
		'path' => '/var/www/rusantic.deploy24.com/',
		'commands' => array('commands update', 'commands dump-autoload')
	),
	'chatter.deploy24.com' => array(
		'branch' => 'master',
		'remote' => 'origin',
		'path' => '/var/www/chatter.deploy24.com/',
		'commands' => array('commands update', 'commands dump-autoload')
	),
);

