<?php

namespace SmallUser\Service;

use Laminas\Diactoros\ServerRequest;
use Laminas\Form\FormInterface;
use Mezzio\Authentication\AuthenticationInterface;
use Mezzio\Flash\FlashMessageMiddleware;
use Mezzio\Flash\FlashMessagesInterface;
use Psr\Http\Message\ServerRequestInterface;
use SmallUser\Entity\UserInterface;
use SmallUser\Form\Login;
use SmallUser\Mapper\HydratorUser;

class User
{
    const ERROR_NAME_SPACE = 'small-user-auth';
    /** @var string */
    protected $failedLoginMessage = 'Authentication failed. Please try again.';

    /** @var AuthenticationInterface */
    protected $authService;
    /** @var FormInterface */
    protected $loginForm;
    /** @var array */
    protected $config;

    /**
     * User constructor.
     * @param AuthenticationService $authService
     * @param FormInterface $loginForm
     * @param array $config
     * @param PluginManager $controllerPluginManager
     */
    public function __construct(
        AuthenticationInterface $authService,
        FormInterface $loginForm,
        array $config
    ) {
        $this->authService = $authService;
        $this->loginForm = $loginForm;
        $this->config = $config;
    }

    public function login(ServerRequestInterface $request)
    {
        $class = $this->getUserEntityClassName();

        $form = $this->getLoginForm();
        $form->setData($request->getParsedBody());

        /** @var FlashMessagesInterface $flashMessages */
        $flashMessages = $request->getAttribute(FlashMessageMiddleware::FLASH_ATTRIBUTE);
        $flashMessages->flash('error', $this->getFailedLoginMessage());

        if (!$form->isValid()) {
            return false;
        }

        if (!$this->isIpAllowed($request)) {
            return false;
        }

        return $this->handleAuth4UserLogin($request);
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
     * @return FormInterface
     */
    public function getLoginForm()
    {
        return $this->loginForm;
    }


    /**
     * @return AuthenticationInterface
     */
    public function getAuthService()
    {
        return $this->authService;
    }

    /**
     * @param ServerRequestInterface $request
     */
    protected function doLogin(ServerRequestInterface $request)
    {

    }

    /**
     * @param AuthenticationService $authService
     * @param UserInterface $user
     * @return \Laminas\Authentication\Result
     */
    protected function getAuthResult(ServerRequestInterface $request)
    {
        return $this->getAuthService()->authenticate($request);
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
    protected function handleInvalidLogin(ServerRequestInterface $request)
    {
        return false;
    }

    /**
     * @return bool
     */
    protected function isIpAllowed(ServerRequestInterface $request)
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
     * @param UserInterface $request
     * @return bool
     */
    protected function handleAuth4UserLogin(ServerRequestInterface $request)
    {
        $user = $this->getAuthResult($request);
        $result = false;

        if ($user !== null) {
            $this->doLogin($user);
        } else {
            $this->handleInvalidLogin($request);
        }

        return $result;
    }

    /**
     * @return array|object
     */
    public function getConfig()
    {
        return $this->config;
    }

}