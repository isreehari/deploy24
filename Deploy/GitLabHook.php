<?php
namespace Deploy;

class GitLabHook extends AbstractHook {
	/**
	 * Decodes and validates the data from github and calls the
	 * doploy contructor to deoploy the new code.
	 *
	 * @param 	string 	$payload 	The JSON encoded payload data.
	 */
	public function payload($payload) {
		$payload = json_decode($payload);
		$name = $payload->repository->name;
		$branch = basename($payload->ref);
		$commit = substr($payload->commits[0]->id, 0, 12);
		if (isset($this->repos[$name]) && $this->repos[$name]['branch'] === $branch) {
			$this->log('Hook repository `' . $name . '` on branch `' . $branch . '`');
			$repo = $this->repos[$name];
			$repo['commit'] = $commit;
			$this->process($name, $repo);
		} else {
			$this->log('No hook for repository `' . $name . '` on branch `' . $branch . '`', 'ERROR');
		}
	}
}
