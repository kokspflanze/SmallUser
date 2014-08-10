<?php

namespace SmallUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class AuthController extends AbstractActionController {
	const ErrorNameSpace = 'small-user-auth';
	const RouteLoggedIn = 'home';
	protected $userService;
	protected $authService;
	protected $loginForm;
	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	protected $entityManager;

	/**
	 * @return array|\Zend\Http\Response
	 */
	public function loginAction() {

		//if already login, redirect to success page
		if ($this->getAuthService()->hasIdentity()){
			return $this->redirect()->toRoute(self::RouteLoggedIn);
		}

		$oForm = $this->getLoginForm();
		$oRequest = $this->getRequest();

		if (!$oRequest->isPost()){
			return array(
				'aErrorMessages' => $this->flashmessenger()->getMessagesFromNamespace(self::ErrorNameSpace),
				'loginForm' => $oForm
			);
		}

		if($this->getUserService()->login($this->params()->fromPost())){
			return $this->redirect()->toRoute(self::RouteLoggedIn);
		}
		return $this->redirect()->toUrl($this->url()->fromRoute('small-user-auth'));
	}

	/**
	 * Logout and clear the identity + Redirect to fix the identity
	 */
	public function logoutAction(){

		$this->getAuthService()->getStorage()->clear();
		$this->getAuthService()->clearIdentity();

		return $this->redirect()->toRoute('small-user-auth', array('action' => 'logout-page'));
	}

	/**
	 * LogoutPage
	 */
	public function logoutPageAction(){
		return array();
	}

	/**
	 * @return \Zend\Authentication\AuthenticationService
	 */
	protected function getAuthService() {
		if (!$this->authService) {
			$this->authService = $this->getServiceLocator()->get('small_user_auth_service');
		}

		return $this->authService;
	}

	/**
	 * @return \SmallUser\Form\Login
	 */
	protected function getLoginForm() {
		if (!$this->loginForm) {
			$this->loginForm = $this->getServiceLocator()->get('small_user_login_form');
		}

		return $this->loginForm;
	}

	/**
	 * @return \PServerCMS\Service\User
	 */
	protected function getUserService(){
		if (!$this->userService) {
			$this->userService = $this->getServiceLocator()->get('small_user_service');
		}

		return $this->userService;
	}

	/**
	 * @return \Doctrine\ORM\EntityManager
	 */
	protected function getEntityManager(){
		if (!$this->entityManager) {
			$this->entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		}

		return $this->entityManager;
	}
} 