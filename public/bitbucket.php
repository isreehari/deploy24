<?php
	define('APP_PATH', dirname(__DIR__));
	define('DEPLOY_LOG_DIR', APP_PATH.'/logs');

	require_once APP_PATH.'/Deploy/AbstractHook.php';
	require_once APP_PATH.'/Deploy/BitBucketHook.php';

	if(isset($_POST['payload']))
	{
		$repos = require_once APP_PATH.'/config/bitbucket.php';

		$hook = new Deploy\BitBucketHook($repos);
		$hook->payload($_POST['payload']);
	}
