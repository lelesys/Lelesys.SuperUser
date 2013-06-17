<?php
namespace Lelesys\SuperUser\Session;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Lelesys.SuperUser".     *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * SuperUser session for the Lelesys.SuperUser package
 *
 * @Flow\Scope("session")
 */
class SuperUserSession {

	/**
	 * The Account
	 *
	 * @var \TYPO3\Flow\Security\Account
	 */
	protected $account;

	/**
	 * Get Account.
	 *
	 * @return \TYPO3\Flow\Security\Account
	 */
	public function getAccount() {
		return $this->account;
	}

	/**
	 * Set Account.
	 *
	 * @param \TYPO3\Flow\Security\Account $account
	 * @Flow\Session(autoStart=TRUE)
	 * @return void
	 */
	public function setAccount(\TYPO3\Flow\Security\Account $account = NULL) {
		$this->account = $account;
	}
}

?>