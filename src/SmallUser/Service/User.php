<?php

namespace SmallUser\Service;

use SmallUser\Entity\UserInterface;
use SmallUser\Form\Login;
use SmallUser\Mapper\HydratorUser;
use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\Mvc\Controller\PluginManager;

class User
{
    const ERROR_NAME_SPACE = 'small-user-auth';
    /** @var string */
    protected $failedLoginMessage = 'Authentication failed. Please try again.';
    /** @var FlashMessenger */
    protected $flashMessenger;

    /** @var AuthenticationService */
    protected $authService;
    /** @var Login */
    protected $loginForm;
    /** @var array */
    protected $config;
    /** @var PluginManager */
    protected $controllerPluginManager;

    /**
     * User constructor.
     * @param AuthenticationService $authService
     * @param Login $loginForm
     * @param array $config
     * @param PluginManager $controllerPluginManager
     */
    public function __construct(
        AuthenticationService $authService,
        Login $loginForm,
        array $config,
        PluginManager $controllerPluginManager
    ) {
        $this->authService = $authService;
        $this->loginForm = $loginForm;
        $this->config = $config;
        $this->controllerPluginManager = $controllerPluginManager;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function login(array $data)
    {
        $class = $this->getUserEntityClassName();

        $form = $this->getLoginForm();
        $form->setHydrator(new HydratorUser());
        $form->bind(new $class);
        $form->setData($data);

        $this->getFlashMessenger()->setNamespace($this::ERROR_NAME_SPACE)->addMessage($this->getFailedLoginMessage());

        if (!$form->isValid()) {
            return false;
        }

        if (!$this->isIpAllowed()) {
            return false;
        }

        /** @var UserInterface $user */
        $user = $form->getData();

        return $this->handleAuth4UserLogin($user);
    }

    /**
     * TODO
     * @param array $data
     * @return UserInterface|bool
     */
    public function register(array $data)
    {

    }

    /**
     * TODO
     *
     * @param array $data
     */
    public function lostPw(array $data)
    {

    }

    /**
     * @return Login
     */
    public function getLoginForm()
    {
        return $this->loginForm;
    }

    /**
     * @return AuthenticationService
     */
    public function getAuthService()
    {
        return $this->authService;
    }

    /**
     * @param UserInterface $user
     */
    protected function doLogin(UserInterface $user)
    {
        $this->getFlashMessenger()->clearCurrentMessagesFromNamespace($this::ERROR_NAME_SPACE);
    }

    /**
     * @param AuthenticationService $authService
     * @param UserInterface $user
     * @return \Zend\Authentication\Result
     */
    protected function getAuthResult(AuthenticationService $authService, UserInterface $user)
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
    protected function setFailedLoginMessage($message)
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
    protected function isValidLogin(UserInterface $user)
    {
        $user->getRoles();

        return true;
    }

    /**
     * Log ips, or check for other things
     * @param UserInterface $user
     * @return bool
     */
    protected function handleInvalidLogin(UserInterface $user)
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
        return $this->config['user_entity']['class'];
    }

    /**
     * @return string
     */
    protected function getUserEntityUserName()
    {
        return $this->config['user_entity']['username'];
    }

    /**
     * @param UserInterface $user
     * @return bool
     */
    protected function handleAuth4UserLogin(UserInterface $user)
    {
        $authService = $this->getAuthService();
        $authResult = $this->getAuthResult($authService, $user);
        $result = false;

        if ($authResult->isValid()) {
            $user = $authResult->getIdentity();
            if ($this->isValidLogin($user)) {
                $this->doLogin($user);

                $result = true;
            } else {
                // Login correct but not active or blocked or smth else
                $authService->clearIdentity();
                $authService->getStorage()->clear();
            }
        } else {
            $this->handleInvalidLogin($user);
        }

        return $result;
    }

    /**
     * @return FlashMessenger
     */
    protected function getFlashMessenger()
    {
        if (!$this->flashMessenger) {
            $this->flashMessenger = $this->getControllerPluginManager()->get('flashMessenger');
        }

        return $this->flashMessenger;
    }

    /**
     * @return array|object
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return PluginManager
     */
    protected function getControllerPluginManager()
    {
        return $this->controllerPluginManager;
    }
}