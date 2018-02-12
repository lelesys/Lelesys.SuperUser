<?php
namespace Lelesys\SuperUser;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Lelesys.SuperUser".     *
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Package\Package as BasePackage;

/**
 * The Lelesys SuperUser Package
 *
 */
class Package extends BasePackage {

	/**
	 * Invokes custom PHP code directly after the package manager has been initialized.
	 *
	 * @param \Neos\Flow\Core\Bootstrap $bootstrap The current bootstrap
	 * @return void
	 */
	public function boot(\Neos\Flow\Core\Bootstrap $bootstrap) {
		$dispatcher = $bootstrap->getSignalSlotDispatcher();
		$dispatcher->connect('Neos\Flow\Mvc\Dispatcher', 'afterControllerInvocation', 'Lelesys\SuperUser\Service\SuperUserService', 'appendLogoutLink');
		$dispatcher->connect('Neos\Flow\Security\Authentication\AuthenticationProviderManager', 'loggedOut', 'Lelesys\SuperUser\Service\SuperUserService', 'appendLogoutLink');
	}
}

?>