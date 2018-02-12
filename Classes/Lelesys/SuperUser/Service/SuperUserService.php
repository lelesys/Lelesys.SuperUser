<?php

namespace Lelesys\SuperUser\Service;

/* *
 * This script belongs to the TYPO3 Flow package "Lelesys.SuperUser".     *
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;

/**
 * SuperUserService for the Lelesys.SuperUser package
 *
 * @Flow\Scope("singleton")
 */
class SuperUserService {

	/**
	 * The Athentication Manager
	 *
	 * @var \Neos\Flow\Security\Authentication\AuthenticationManagerInterface
	 * @Flow\Inject
	 */
	protected $authenticationManager;

	/**
	 * The security conntext
	 *
	 * @var \Neos\Flow\Security\Context
	 * @Flow\Inject
	 */
	protected $securityContext;

	/**
	 * The suepruser session
	 *
	 * @var \Lelesys\SuperUser\Session\SuperUserSession
	 * @Flow\Inject
	 */
	protected $superUserSession;

	/**
	 * @var \Neos\Flow\Core\Bootstrap
	 * @Flow\Inject
	 */
	protected $bootstrap;

	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * Inject settings
	 *
	 * @param array $settings
	 * @return void
	 */
	public function injectSettings(array $settings) {
		$this->settings = $settings;
	}

	/**
	 * Superuser will loginn as User.
	 *
	 * @param \Neos\Flow\Security\Account $account
	 * @return boolean
	 */
	public function loginAsUser(\Neos\Flow\Security\Account $account) {
		try {
			$superUserAccount = $this->securityContext->getAccount();
			$this->superUserSession->setAccount($superUserAccount);
			$tokens = $this->securityContext->getAuthenticationTokens();
			foreach ($tokens as $token) {
				$token->setAccount($account);
			}
			return TRUE;
		} catch (\Neos\Flow\Exception $e) {
			return FALSE;
		}
	}

	/**
	 * User will be logout and Superuser's account will get set to the token.
	 *
	 * @return void
	 */
	public function logoutAsUser() {
		$superUserAccount = $this->superUserSession->getAccount();
		if ($superUserAccount !== NULL) {
			$tokens = $this->securityContext->getAuthenticationTokens();
			foreach ($tokens as $token) {
				$token->setAccount($superUserAccount);
			}
		}
		$this->superUserSession->setAccount(NULL);
	}

	/**
	 * Append logout link for Superuser.
	 *
	 * @param \Neos\Flow\Mvc\RequestInterface $request
	 * @param \Neos\Flow\Mvc\ResponseInterface $response
	 * @return void
	 */
	public function appendLogoutLink($request = NULL, \Neos\Flow\Mvc\ResponseInterface $response = NULL) {
		if ($request instanceof \Neos\Flow\Mvc\ActionRequest
				&& $response instanceof \Neos\Flow\Mvc\ResponseInterface) {
			$server = \Neos\Utility\ObjectAccess::getProperty($request->getHttpRequest(), 'server', TRUE);
			if ((isset($server['HTTP_X_REQUESTED_WITH']) === FALSE
					&& $this->superUserSession->getAccount() !== NULL)
					|| (isset($server['HTTP_X_REQUESTED_WITH'])
					&& !empty($server['HTTP_X_REQUESTED_WITH'])
					&& strtolower($server['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest'
					&& $this->superUserSession->getAccount() !== NULL)
			) {
				$standaloneView = new \Neos\FluidAdaptor\View\StandaloneView($request);
				$standaloneView->assign('account', $this->securityContext->getAccount());
				$standaloneView->setTemplatePathAndFilename($this->settings['templatePathAndFilename']);
				$response->appendContent($standaloneView->render());
			}
		}
	}

	/**
	 * Clear Superuser account at logout signal.
	 *
	 * @return void
	 */
	public function clearSuperUserAccount() {
		$this->superUserSession->setAccount(NULL);
	}

}

?>