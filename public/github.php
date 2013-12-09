<?php
	define('APP_PATH', dirname(__DIR__));
	define('DEPLOY_LOG_DIR', APP_PATH.'/logs');

	require_once APP_PATH.'/Deploy/AbstractHook.php';
	require_once APP_PATH.'/Deploy/GitHubHook.php';

	if(isset($_POST['payload']))
	{
		$repos = require_once APP_PATH.'/config/github.php';

		$hook = new Deploy\GitHubHook($repos);
		$hook->payload($_POST['payload']);
	}
