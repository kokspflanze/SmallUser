<?php

namespace SmallUser\Service;


use SmallUser\Entity\Users;
use SmallUser\Entity\UsersInterface;
use SmallUser\Mapper\HydratorUser;

class User extends InvokableBase {
	const ErrorNameSpace = 'small-user-auth';
	/** @var \Zend\Authentication\AuthenticationService */
	protected $authService;
	/** @var \SmallUser\Form\Login */
	protected $loginForm;
	/** @var string */
	protected $failedLoginMessage = 'Authentication failed. Please try again.';

	/**
	 * @param array $aData
	 * @return bool
	 */
	public function login( array $aData ){

		$oForm = $this->getLoginForm();
		$oForm->setHydrator( new HydratorUser() );
		$oForm->bind( new Users() );
		$oForm->setData($aData);

		$this->getFlashMessenger()->setNamespace(self::ErrorNameSpace)->addMessage($this->getFailedLoginMessage());
		if(!$oForm->isValid()){
			return false;
		}
		if(!$this->isIpAllowed()){
			return false;
		}
		/** @var \SmallUser\Entity\Users $oUser */
		$oUser = $oForm->getData();
		$oAuthService = $this->getAuthService();
		$oResult = $this->getAuthResult($oAuthService,$oUser);
		if($oResult->isValid()){
			/** @var \SmallUser\Entity\Users $oUser */
			$oUser = $oResult->getIdentity();
			if($this->isValidLogin($oUser)){
				$this->doLogin($oUser);
				return true;
			}else{
				// Login correct but not active or blocked or smth else
				$oAuthService->clearIdentity();
				$oAuthService->getStorage()->clear();
			}
		}else{
			$this->handleInvalidLogin($oUser);
		}
		return false;
	}

	/**
	 *	TODO TEST
	 */
	public function doAuthentication( UsersInterface $oUser ){
		$oAuthService = $this->getAuthService();
		// FIX: no roles after register
		$oUser->getRoles();
		$oAuthService->getStorage()->write($oUser);
	}

	/**
	 * TODO
	 *
	 * @param array $aData
	 *
	 * @return UsersInterface|bool
	 */
	public function register( array $aData ){

	}

	/**
	 * TODO
	 *
	 * @param array $aData
	 */
	public function lostPw( array $aData ){

	}


	/**
	 * @param UsersInterface $oUser
	 */
	protected function doLogin(UsersInterface $oUser) {
		$this->getFlashMessenger()->clearCurrentMessagesFromNamespace(self::ErrorNameSpace);
	}

	/**
	 * @param \Zend\Authentication\AuthenticationService $oAuthService
	 * @param UsersInterface $oUser
	 * @return \Zend\Authentication\Result
	 */
	protected function getAuthResult(\Zend\Authentication\AuthenticationService $oAuthService, UsersInterface $oUser){
		/** @var \DoctrineModule\Authentication\Adapter\ObjectRepository $oAdapter */
		$oAdapter = $oAuthService->getAdapter();
		$oAdapter->setIdentity($oUser->getUsername());
		$oAdapter->setCredential($oUser->getPassword());
		return $oAuthService->authenticate($oAdapter);
	}


	/**
	 * @return \Zend\Authentication\AuthenticationService
	 */
	protected function getAuthService() {
		if (! $this->authService) {
			$this->authService = $this->getServiceManager()->get('small_user_auth_service');
		}

		return $this->authService;
	}

	/**
	 * @return \SmallUser\Form\Login
	 */
	protected function getLoginForm() {
		if (! $this->loginForm) {
			$this->loginForm = $this->getServiceManager()->get('small_user_login_form');
		}

		return $this->loginForm;
	}

	/**
	 * @param $sMessage
	 */
	protected function setFailedLoginMessage( $sMessage ){
		$this->failedLoginMessage = $sMessage;
	}

	/**
	 * @return string
	 */
	protected function getFailedLoginMessage() {
		return $this->failedLoginMessage;
	}

	/**
	 * @param UsersInterface $oUser
	 * @return bool
	 */
	protected function isValidLogin( UsersInterface $oUser ) {
		return true;
	}

	/**
	 * Log ips, or check for other things
	 * @param UsersInterface $oUser
	 *
	 * @return bool
	 */
	protected function handleInvalidLogin( UsersInterface $oUser ) {
		return false;
	}

	/**
	 * @return bool
	 */
	protected function isIpAllowed(){
		return true;
	}
}