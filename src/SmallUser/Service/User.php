<?php

namespace SmallUser\Service;

use SmallUser\Entity\UserInterface;
use SmallUser\Mapper\HydratorUser;

class User extends InvokableBase
{
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
	public function login( array $data )
    {
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

		$user = $form->getData();
		$authService = $this->getAuthService();
		$result = $this->getAuthResult($authService, $user);
		if($result->isValid()){
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
	 * TODO

	 * @param array $data

	 * @return UserInterface|bool
	 */
	public function register( array $data )
    {

	}

	/**
	 * TODO
	 *
	 * @param array $data
	 */
	public function lostPw( array $data )
    {

	}

	/**
	 * @return \SmallUser\Form\Login
	 */
	public function getLoginForm()
    {
		if (! $this->loginForm) {
			$this->loginForm = $this->getServiceManager()->get('small_user_login_form');
		}

		return $this->loginForm;
	}

	/**
	 * @return \Zend\Authentication\AuthenticationService
	 */
	public function getAuthService()
    {
		if (! $this->authService) {
			$this->authService = $this->getServiceManager()->get('small_user_auth_service');
		}

		return $this->authService;
	}

	/**
	 * @param UserInterface $user
	 */
	protected function doLogin(UserInterface $user)
    {
		$this->getFlashMessenger()->clearCurrentMessagesFromNamespace(self::ErrorNameSpace);
	}

	/**
	 * @param \Zend\Authentication\AuthenticationService $authService
	 * @param UserInterface $user
	 * @return \Zend\Authentication\Result
	 */
	protected function getAuthResult(\Zend\Authentication\AuthenticationService $authService, UserInterface $user)
    {
		/** @var \DoctrineModule\Authentication\Adapter\ObjectRepository $adapter */
		$adapter = $authService->getAdapter();
		$adapter->setIdentity($user->getUsername());
		$adapter->setCredential($user->getPassword());

		return $authService->authenticate($adapter);
	}

	/**
	 * @param $message
	 */
	protected function setFailedLoginMessage( $message )
    {
		$this->failedLoginMessage = $message;
	}

	/**
	 * @return string
	 */
	protected function getFailedLoginMessage()
    {
		return $this->failedLoginMessage;
	}

	/**
	 * @TODO better fix
	 * @param UserInterface $user
	 * @return bool
	 */
	protected function isValidLogin( UserInterface $user )
    {
		$user->getRoles();

		return true;
	}

	/**
	 * Log ips, or check for other things
	 * @param UserInterface $user

	 * @return bool
	 */
	protected function handleInvalidLogin( UserInterface $user )
    {
		return false;
	}

	/**
	 * @return bool
	 */
	protected function isIpAllowed()
    {
		return true;
	}

	/**
	 * @return string
	 */
	protected function getUserEntityClassName()
    {
		if (! $this->userEntityClassName) {
			$this->userEntityClassName = $this->getConfig()['small-user']['user_entity']['class'];
		}

		return $this->userEntityClassName;
	}

	/**
	 * @return string
	 */
	protected function getUserEntityUserName()
    {
		if (! $this->userEntityUserName) {
			$this->userEntityUserName = $this->getConfig()['small-user']['user_entity']['username'];
		}

		return $this->userEntityUserName;
	}
}