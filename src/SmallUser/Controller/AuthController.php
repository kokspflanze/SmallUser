<?php

namespace SmallUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AuthController extends AbstractActionController
{
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
    public function loginAction()
    {
        //if already login, redirect to success page
        if ($this->getUserService()->getAuthService()->hasIdentity()) {
            return $this->redirect()->toRoute( $this->getLoggedInRoute() );
        }

        $form    = $this->getUserService()->getLoginForm();
        $request = $this->getRequest();

        if (!$request->isPost()) {
            $view = new ViewModel( array(
                'aErrorMessages' => $this->flashmessenger()->getMessagesFromNamespace( self::ErrorNameSpace ),
                'loginForm'      => $form
            ) );
            $view->setTemplate( 'small-user/login' );

            return $view;
        }

        if ($this->getUserService()->login( $this->params()->fromPost() )) {
            return $this->redirect()->toRoute( $this->getLoggedInRoute() );
        }

        return $this->redirect()->toUrl( $this->url()->fromRoute( 'small-user-auth' ) );
    }

    /**
     * @return string
     */
    protected function getLoggedInRoute()
    {
        $configRoute = $this->getUserService()->getConfig()['small-user']['login']['route'];

        return $configRoute != false ? $configRoute : self::RouteLoggedIn;
    }

    /**
     * Logout and clear the identity + Redirect to fix the identity
     */
    public function logoutAction()
    {
        $this->getUserService()->getAuthService()->getStorage()->clear();
        $this->getUserService()->getAuthService()->clearIdentity();

        return $this->redirect()->toRoute( 'small-user-auth', array( 'action' => 'logout-page' ) );
    }

    /**
     * LogoutPage
     */
    public function logoutPageAction()
    {
        $view = new ViewModel();
        $view->setTemplate( 'small-user/logout-page' );

        return $view;
    }

    /**
     * @return \SmallUser\Service\User
     */
    protected function getUserService()
    {
        if (!$this->userService) {
            $this->userService = $this->getServiceLocator()->get( 'small_user_service' );
        }

        return $this->userService;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        if (!$this->entityManager) {
            $this->entityManager = $this->getServiceLocator()->get( 'Doctrine\ORM\EntityManager' );
        }

        return $this->entityManager;
    }
} 
