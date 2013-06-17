<?php
namespace Lelesys\SuperUser\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Lelesys.SuperUser".     *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * Login controller for the Lelesys.SuperUser package
 *
 * @Flow\Scope("singleton")
 */
class LoginController extends \TYPO3\Flow\Mvc\Controller\ActionController {

	/**
	 * The SuperUserService
	 *
	 * @var \Lelesys\SuperUser\Service\SuperUserService
	 * @Flow\Inject
	 */
	protected $superUserService;

	/**
	 * Superuser can login as other user ang get redirected to Users home page.
	 *
	 * @param \TYPO3\Flow\Security\Account $account
	 * @return void
	 */
	public function loginAsUserAction(\TYPO3\Flow\Security\Account $account) {
		if (empty($this->settings['superUserRedirectOptions']['loginAsUserFailed']['package'])
			|| empty($this->settings['superUserRedirectOptions']['loginAsUserFailed']['controller'])
			|| empty($this->settings['superUserRedirectOptions']['loginAsUserFailed']['action'])) {
				throw new \Lelesys\SuperUser\Exception('Superuser redirect options for login as user failed are not set', 1371037253);
		}

		if (empty($this->settings['superUserRedirectOptions']['loginAsUserSuccess']['package'])
			|| empty($this->settings['superUserRedirectOptions']['loginAsUserSuccess']['controller'])
			|| empty($this->settings['superUserRedirectOptions']['loginAsUserSuccess']['action'])) {
				throw new \Lelesys\SuperUser\Exception('Superuser redirect options for login as user success are not set', 1371037260);
		}

		if ($this->superUserService->loginAsUser($account)) {
			$this->redirect(
					$this->settings['superUserRedirectOptions']['loginAsUserSuccess']['action'],
					$this->settings['superUserRedirectOptions']['loginAsUserSuccess']['controller'],
					$this->settings['superUserRedirectOptions']['loginAsUserSuccess']['package']
				);
		} else {
			$this->redirect(
					$this->settings['superUserRedirectOptions']['loginAsUserFailed']['action'],
					$this->settings['superUserRedirectOptions']['loginAsUserFailed']['controller'],
					$this->settings['superUserRedirectOptions']['loginAsUserFailed']['package']
				);
		}
	}

	/**
	 * Logout SuperUser as user and redirect it back to SuperUser page.
	 *
	 * @return void
	 */
	public function logoutAsUserAction() {
		if (empty($this->settings['superUserRedirectOptions']['logoutAsUser']['package'])
			|| empty($this->settings['superUserRedirectOptions']['logoutAsUser']['controller'])
			|| empty($this->settings['superUserRedirectOptions']['logoutAsUser']['action'])) {
				throw new \Lelesys\SuperUser\Exception('Superuser redirect options for logout as user are not set', 1371037270);
		}

		$this->superUserService->logoutAsUser();
		$this->redirect(
					$this->settings['superUserRedirectOptions']['logoutAsUser']['action'],
					$this->settings['superUserRedirectOptions']['logoutAsUser']['controller'],
					$this->settings['superUserRedirectOptions']['logoutAsUser']['package']
				);
	}

}

?>