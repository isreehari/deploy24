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
			$repo = $this->repos[$name];
			$repo['commit'] = $payload['commits'][0]['node'];
			$this->process($name, $repo);
		}
	}
}
