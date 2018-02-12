<?php
namespace Lelesys\SuperUser\Session;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Lelesys.SuperUser".     *
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;

/**
 * SuperUser session for the Lelesys.SuperUser package
 *
 * @Flow\Scope("session")
 */
class SuperUserSession {

	/**
	 * The Account
	 *
	 * @var \Neos\Flow\Security\Account
	 */
	protected $account;

	/**
	 * Get Account.
	 *
	 * @return \Neos\Flow\Security\Account
	 */
	public function getAccount() {
		return $this->account;
	}

	/**
	 * Set Account.
	 *
	 * @param \Neos\Flow\Security\Account $account
	 * @Flow\Session(autoStart=TRUE)
	 * @return void
	 */
	public function setAccount(\Neos\Flow\Security\Account $account = NULL) {
		$this->account = $account;
	}
}

?>