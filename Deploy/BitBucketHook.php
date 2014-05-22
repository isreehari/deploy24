<?php
namespace Deploy;

class BitBucketHook extends AbstractHook {
	/**
	 * Decodes and validates the data from bitbucket and calls the
	 * doploy contructor to deoploy the new code.
	 *
	 * @param 	string 	$payload 	The JSON encoded payload data.
	 */
	public function payload($payload) {
		$payload = json_decode(stripslashes($payload), true);
		$name = $payload['repository']['name'];
		if (isset($this->repos[$name]) && $this->repos[$name]['branch'] === $payload['commits'][0]['branch']) {
			$this->log('Hook repository `' . $name . '` on branch `' . $branch . '`');
			$repo = $this->repos[$name];
			$repo['commit'] = $commit;
			$this->process($name, $repo);
		} else {
			$this->log('No hook for repository `' . $name . '` on branch `' . $branch . '`', 'ERROR');
		}
	}
}
