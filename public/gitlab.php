<?php
	define('APP_PATH', dirname(__DIR__));
	define('DEPLOY_LOG_DIR', APP_PATH.'/logs');

	require_once APP_PATH.'/Deploy/AbstractHook.php';
	require_once APP_PATH.'/Deploy/GitLabHook.php';

	if(isset($_POST['payload']))
	{
		$repos = require_once APP_PATH.'/config/gitlab.php';

		$hook = new Deploy\GitLabHook($repos);
		$hook->payload($_POST['payload']);
	}
