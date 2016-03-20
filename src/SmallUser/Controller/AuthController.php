<?php

namespace SmallUser\Controller;

use SmallUser\Service\User;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AuthController extends AbstractActionController
{
    const ERROR_NAME_SPACE = 'small-user-auth';
    const ROUTE_LOGGED_IN = 'home';

    /** @var  User */
    protected $userService;

    /**
     * AuthController constructor.
     * @param User $userService
     */
    public function __construct(User $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @return array|\Zend\Http\Response
     */
    public function loginAction()
    {
        //if already login, redirect to success page
        if ($this->getUserService()->getAuthService()->hasIdentity()) {
            return $this->redirect()->toRoute($this->getLoggedInRoute());
        }

        $form = $this->getUserService()->getLoginForm();

        /** @var \Zend\Http\Request $request */
        $request = $this->getRequest();

        if (!$request->isPost()) {
            $view = new ViewModel([
                'aErrorMessages' => $this->flashMessenger()->getMessagesFromNamespace($this::ERROR_NAME_SPACE),
                'loginForm' => $form
            ]);
            $view->setTemplate('small-user/login');

            return $view;
        }

        if ($this->getUserService()->login($this->params()->fromPost())) {
            return $this->redirect()->toRoute($this->getLoggedInRoute());
        }

        return $this->redirect()->toUrl($this->url()->fromRoute('small-user-auth'));
    }

    /**
     * @return string
     */
    protected function getLoggedInRoute()
    {
        $configRoute = $this->getUserService()->getConfig()['login']['route'];

        return $configRoute != false ? $configRoute : $this::ROUTE_LOGGED_IN;
    }

    /**
     * Logout and clear the identity + Redirect to fix the identity
     */
    public function logoutAction()
    {
        $this->getUserService()->getAuthService()->getStorage()->clear();
        $this->getUserService()->getAuthService()->clearIdentity();

        return $this->redirect()->toRoute('small-user-auth', ['action' => 'logout-page']);
    }

    /**
     * LogoutPage
     */
    public function logoutPageAction()
    {
        $view = new ViewModel();
        $view->setTemplate('small-user/logout-page');

        return $view;
    }

    /**
     * @return \SmallUser\Service\User
     */
    protected function getUserService()
    {
        return $this->userService;
    }
} 
