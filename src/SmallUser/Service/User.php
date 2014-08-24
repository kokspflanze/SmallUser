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
	/** @var string */
	protected $userEntityClassName;
	/** @var string */
	protected $userEntityUserName;

	/**
	 * @param array $data
	 * @return bool
	 */
	public function login( array $data ){

		$class = $this->getUserEntityClassName();

		$form = $this->getLoginForm();
		$form->setHydrator( new HydratorUser() );
		$form->bind( new $class );
		$form->setData( $data);

		$this->getFlashMessenger()->setNamespace(self::ErrorNameSpace)->addMessage($this->getFailedLoginMessage());
		if(!$form->isValid()){
			return false;
		}
		if(!$this->isIpAllowed()){
			return false;
		}
		/** @var \SmallUser\Entity\Users $user */
		$user = $form->getData();
		$authService = $this->getAuthService();
		$result = $this->getAuthResult($authService, $user);
		if($result->isValid()){
			/** @var \SmallUser\Entity\Users $oUser */
			$user = $result->getIdentity();
			if($this->isValidLogin($user)){
				$this->doLogin($user);
				return true;
			}else{
				// Login correct but not active or blocked or smth else
				$authService->clearIdentity();
				$authService->getStorage()->clear();
			}
		}else{
			$this->handleInvalidLogin($user);
		}
		return false;
	}

	/**
	 * Login with a User
	 * @param UsersInterface $user
	 */
	public function doAuthentication( UsersInterface $user ){
		$find = array($this->getUserEntityUserName() => $user->getUsername());
		$user = $this->getEntityManager()->getRepository($this->getUserEntityClassName())->findOneBy($find);

		$authService = $this->getAuthService();
		// FIX: no roles after register
		$user->getRoles();
		$authService->getStorage()->write($user);
	}

	/**
	 * TODO
	 *
	 * @param array $data
	 *
	 * @return UsersInterface|bool
	 */
	public function register( array $data ){

	}

	/**
	 * TODO
	 *
	 * @param array $data
	 */
	public function lostPw( array $data ){

	}

	/**
	 * @return \SmallUser\Form\Login
	 */
	public function getLoginForm() {
		if (! $this->loginForm) {
			$this->loginForm = $this->getServiceManager()->get('small_user_login_form');
		}

		return $this->loginForm;
	}

	/**
	 * @return \Zend\Authentication\AuthenticationService
	 */
	public function getAuthService() {
		if (! $this->authService) {
			$this->authService = $this->getServiceManager()->get('small_user_auth_service');
		}

		return $this->authService;
	}

	/**
	 * @param UsersInterface $user
	 */
	protected function doLogin(UsersInterface $user) {
		$this->getFlashMessenger()->clearCurrentMessagesFromNamespace(self::ErrorNameSpace);
	}

	/**
	 * @param \Zend\Authentication\AuthenticationService $authService
	 * @param UsersInterface $user
	 * @return \Zend\Authentication\Result
	 */
	protected function getAuthResult(\Zend\Authentication\AuthenticationService $authService, UsersInterface $user){
		/** @var \DoctrineModule\Authentication\Adapter\ObjectRepository $adapter */
		$adapter = $authService->getAdapter();
		$adapter->setIdentity($user->getUsername());
		$adapter->setCredential($user->getPassword());
		return $authService->authenticate($adapter);
	}

	/**
	 * @param $message
	 */
	protected function setFailedLoginMessage( $message ){
		$this->failedLoginMessage = $message;
	}

	/**
	 * @return string
	 */
	protected function getFailedLoginMessage() {
		return $this->failedLoginMessage;
	}

	/**
	 * @param UsersInterface $user
	 * @return bool
	 */
	protected function isValidLogin( UsersInterface $user ) {
		return true;
	}

	/**
	 * Log ips, or check for other things
	 * @param UsersInterface $user
	 *
	 * @return bool
	 */
	protected function handleInvalidLogin( UsersInterface $user ) {
		return false;
	}

	/**
	 * @return bool
	 */
	protected function isIpAllowed(){
		return true;
	}

	/**
	 * @return string
	 */
	protected function getUserEntityClassName(){
		if (! $this->userEntityClassName) {
			$config = $this->getServiceManager()->get('Config');
			$this->userEntityClassName = $config['small-user']['user_entity']['class'];
		}

		return $this->userEntityClassName;
	}

	/**
	 * @return string
	 */
	protected function getUserEntityUserName(){
		if (! $this->userEntityUserName) {
			$config = $this->getServiceManager()->get('Config');
			$this->userEntityUserName = $config['small-user']['user_entity']['username'];
		}

		return $this->userEntityUserName;
	}
}