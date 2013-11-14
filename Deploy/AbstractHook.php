<?php
namespace Deploy;

/**
 * The main Deploy class. This is set up for GIT repos.
 *
 * To create an end point, extend this abstract class and in the new class' constructor
 * parse whatever post payload and pass it to parent::construct(). The data passed should
 * be an array that is in the following order(note this is right in line with how the
 * config arrays are put together).
 * 'repo name' => array(
 *        'name'   => 'repo name', // Required
 *        'path'     => '/path/to/local/repo/' // Required
 *        'branch' => 'the_desired_deploy_branch', // Required
 *        'commit' => 'the SHA of the commit', // Optional. The SHA is only used in logging.
 *        'remote' => 'git_remote_repo', // Optional. Defaults to 'origin'
 *        'callback' => 'callback' // Optional callback function for whatever.
 *)
 *
 * The parent constructor will take care of the rest of the setup and deploy.
 *
 * @todo move the logging functions to a separate class to separate the functionality.
 */

abstract class AbstractHook {
    /**
     * The name of the file that will be used for logging deployments. Set
     * to false to disable logging.
     */
    public $logEnable = true;

    /**
     * Registered deploy repos
     */
    protected $repos = array();

    /**
     * The name of the file that will be used for logging deployments. Set
     * to false to disable logging.
     */
    private $logName = 'deploy.log';

    /**
     * The path to where we wish to store our log file.
     */
    private $logPath = DEPLOY_LOG_DIR;

    /**
     * The timestamp format used for logging.
     *
     * @link    http://www.php.net/manual/en/function.date.php
     */
    private $logDateFormat = 'Y-m-d H:i:sP';

    /**
     * The name of the repo we are attempting deployment for.
     */
    private $name;

    /**
     * The name of the branch to pull from.
     */
    private $branch;

    /**
     * The name of the remote to pull from.
     */
    private $remote;

    /**
     * The path to where your website and git repository are located, can be
     * a relative or absolute path
     */
    private $path;

    /**
     * A callback function to call after the deploy has finished.
     */
    private $composer;

    /**
     * A callback function to call after the deploy has finished.
     */
    private $callback;

    /**
     * The commit that we are attempting to deploy
     */
    private $commit;

    /**
     * Setup hook repos and params
     *
     * @param    array    $config
     */
    public function __construct($config) {
        foreach ($config as $name => $repo) {
            $this->registerRepo($name, $repo);
        }
    }

    /**
     * Init payload
     *
     * @param    array    $payload
     */
    abstract public function payload($payload);

    /**
     * Sets up the repo information.
     *
     * @param    array    $repo    The repository info. See class block for docs.
     */
    protected function process($name, $repo) {
        $this->path = realpath($repo['path']) . DIRECTORY_SEPARATOR;

        $this->name = $name;

        $available_options = array('branch', 'remote', 'commit', 'callback', 'composer');

        foreach($repo as $option => $value){
            if(in_array($option, $available_options)){
                $this->{$option} = $value;
            }
        }

        $this->execute();
    }

    /**
     * Registers available repos for deployement
     *
     * @param array $repo The repo information and the path information for deployment
     * @return bool True on success, false on failure.
     */
    protected function registerRepo($name, $repo) {
        if(!is_string($name)) {
            return false;
        }

        if(!is_array($repo)) {
            return false;
        }

        $required_keys = array('path', 'branch');
        foreach($required_keys as $key) {
            if(!array_key_exists($key, $repo)) {
                return false;
            }
        }

        $defaults = array(
            'remote' => 'origin',
            'callback' => '',
            'commit' => '',
            'composer' => false
        );
        $repo = array_merge($defaults, $repo);

        $this->repos[$name] = $repo;
    }

    /**
     * Writes a message to the log file.
     *
     * @param    string    $message    The message to write
     * @param    string    $type        The type of log message(e.g. INFO, DEBUG, ERROR, etc.)
     */
    protected function log($message, $type = 'INFO') {
    	if($this->logEnable) {
	        $filename = $this->logPath . '/' . rtrim($this->logName, '/');

	        if(!file_exists($filename)) {
	            file_put_contents($filename, '');
	            chmod($filename, 0666);
	        }

	        file_put_contents($filename, date($this->logDateFormat) . ' --- ' . $type . ': ' . $message . PHP_EOL, FILE_APPEND);
	    }
    }

    /**
    * Executes the necessary commands to deploy the code.
    */
    private function execute() {
        try {
            // Make sure we're in the right directory
            chdir($this->path);

            // Discard any changes to tracked files since our last deploy
            exec('git reset --hard HEAD');

            // Update the local repository
            exec('git pull ' . $this->remote . ' ' . $this->branch);

            // Secure the .git directory
            exec('chmod -R og-rx .git');

            if($this->composer) {
                // Composer update
                exec('composer update');
            }

            if(is_callable($this->callback)) {
                call_user_func($this->callback);
            }

            $this->log('[SHA: ' . $this->commit . '] Deployment of ' . $this->name . ' from branch ' . $this->branch . ' successful');
        } catch(Exception $e) {
            $this->log($e, 'ERROR');
        }
    }
}
