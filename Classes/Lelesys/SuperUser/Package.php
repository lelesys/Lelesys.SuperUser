<?php
namespace Lelesys\SuperUser;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Lelesys.SuperUser".     *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Package\Package as BasePackage;

/**
 * The Lelesys SuperUser Package
 *
 */
class Package extends BasePackage {

	/**
	 * Invokes custom PHP code directly after the package manager has been initialized.
	 *
	 * @param \TYPO3\Flow\Core\Bootstrap $bootstrap The current bootstrap
	 * @return void
	 */
	public function boot(\TYPO3\Flow\Core\Bootstrap $bootstrap) {
		$dispatcher = $bootstrap->getSignalSlotDispatcher();
		$dispatcher->connect('TYPO3\Flow\Mvc\Dispatcher', 'afterControllerInvocation', 'Lelesys\SuperUser\Service\SuperUserService', 'appendLogoutLink');
		$dispatcher->connect('TYPO3\Flow\Security\Authentication\AuthenticationProviderManager', 'loggedOut', 'Lelesys\SuperUser\Service\SuperUserService', 'appendLogoutLink');
	}
}

?>