<?php

namespace Lelesys\SuperUser\Controller;

/* *
 * This script belongs to the TYPO3 Flow package "Lelesys.SuperUser".     *
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;

/**
 * Login controller for the Lelesys.SuperUser package
 *
 * @Flow\Scope("singleton")
 */
class LoginController extends \Neos\Flow\Mvc\Controller\ActionController {

	/**
	 * The SuperUserService
	 *
	 * @var \Lelesys\SuperUser\Service\SuperUserService
	 * @Flow\Inject
	 */
	protected $superUserService;

	/**
	 * The security conntext
	 *
	 * @var \Neos\Flow\Security\Context
	 * @Flow\Inject
	 */
	protected $securityContext;

	/**
	 * Superuser can login as other user ang get redirected to Users home page.
	 *
	 * @param \Neos\Flow\Security\Account $account
	 * @param array $additionalParameters
	 * @return void
	 */
	public function loginAsUserAction(\Neos\Flow\Security\Account $account, array $additionalParameters = array()) {
		$roles = $account->getRoles();
		foreach ($roles as $role) {
			$loginUserRole = $role->__toString();
			break;
		}
		$userRoles = $this->settings['superUserRedirectOptions']['loginAsUserFailed']['roles'];
		foreach ($userRoles as $key => $userRole) {
			if ($loginUserRole === $key) {
				if (empty($this->settings['superUserRedirectOptions']['loginAsUserFailed']['roles'][$key]['package'])
						|| empty($this->settings['superUserRedirectOptions']['loginAsUserFailed']['roles'][$key]['controller'])
						|| empty($this->settings['superUserRedirectOptions']['loginAsUserFailed']['roles'][$key]['action'])) {
					throw new \Lelesys\SuperUser\Exception('Superuser redirect options for login as user failed are not set', 1371037253);
				}

				if (empty($this->settings['superUserRedirectOptions']['loginAsUserSuccess']['roles'][$key]['package'])
						|| empty($this->settings['superUserRedirectOptions']['loginAsUserSuccess']['roles'][$key]['controller'])
						|| empty($this->settings['superUserRedirectOptions']['loginAsUserSuccess']['roles'][$key]['action'])) {
					throw new \Lelesys\SuperUser\Exception('Superuser redirect options for login as user success are not set', 1371037260);
				}

				if ($this->superUserService->loginAsUser($account)) {
					$this->redirect(
							$this->settings['superUserRedirectOptions']['loginAsUserSuccess']['roles'][$key]['action'], $this->settings['superUserRedirectOptions']['loginAsUserSuccess']['roles'][$key]['controller'], $this->settings['superUserRedirectOptions']['loginAsUserSuccess']['roles'][$key]['package'], $additionalParameters
					);
				} else {
					$this->redirect(
							$this->settings['superUserRedirectOptions']['loginAsUserFailed']['roles'][$key]['action'], $this->settings['superUserRedirectOptions']['loginAsUserFailed']['roles'][$key]['controller'], $this->settings['superUserRedirectOptions']['loginAsUserFailed']['roles'][$key]['package'], $additionalParameters
					);
				}
			}
		}
	}

	/**
	 * Logout SuperUser as user and redirect it back to SuperUser page.
	 *
	 * @return void
	 */
	public function logoutAsUserAction() {
		$roles = $this->securityContext->getAccount()->getRoles();
		foreach ($roles as $role) {
			$loginUserRole = $role->__toString();
			break;
		}
		$userRoles = $this->settings['superUserRedirectOptions']['loginAsUserFailed']['roles'];
		foreach ($userRoles as $key => $userRole) {
			if ($loginUserRole === $key) {
				if (empty($this->settings['superUserRedirectOptions']['logoutAsUser']['roles'][$key]['package'])
						|| empty($this->settings['superUserRedirectOptions']['logoutAsUser']['roles'][$key]['controller'])
						|| empty($this->settings['superUserRedirectOptions']['logoutAsUser']['roles'][$key]['action'])) {
					throw new \Lelesys\SuperUser\Exception('Superuser redirect options for logout as user are not set', 1371037270);
				}

				$this->superUserService->logoutAsUser();
				$this->redirect(
						$this->settings['superUserRedirectOptions']['logoutAsUser']['roles'][$key]['action'], $this->settings['superUserRedirectOptions']['logoutAsUser']['roles'][$key]['controller'], $this->settings['superUserRedirectOptions']['logoutAsUser']['roles'][$key]['package']
				);
			}
		}
	}

}

?>