<?php

namespace SmallUser\Handler;

use SmallUser\Service\User;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Authentication\UserInterface;
use Mezzio\Session\SessionInterface;
use Mezzio\Session\SessionMiddleware;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SmallUser\Service\User;

class LoginHandler extends AbstractActionHandler
{
    protected User $user;

    protected TemplateRendererInterface $templateRenderer;

    public function __construct(User $user, TemplateRendererInterface $templateRenderer)
    {
        $this->user             = $user;
        $this->templateRenderer = $templateRenderer;
    }

    public function loginAction(ServerRequestInterface $request): ResponseInterface
    {
        $user = $request->getAttribute(UserInterface::class);

        //if already login, redirect to success page
        if ($user !== null) {
            return new RedirectResponse($this->getLoggedInRoute());
        }

        $form = $this->getUserService()->getLoginForm();

        if ($request->getMethod() === 'POST') {
            if ($this->getUserService()->login($request)) {
                return new RedirectResponse($this->getLoggedInRoute());
            }
        }

        $data = [
            'loginForm' => $form,
        ];

        return new HtmlResponse($this->templateRenderer->render('app::login', $data));
    }

    /**
     * @return string
     */
    protected function getLoggedInRoute()
    {
        return $this->getUserService()->getConfig()['login']['route'];
    }

    /**
     * Logout and clear the identity + Redirect to fix the identity
     */
    public function logoutAction(ServerRequestInterface $request)
    {
        $session = $request->getAttribute(SessionMiddleware::SESSION_ATTRIBUTE);
        if ($session instanceof SessionInterface) {
            $session->clear();
            $session->regenerate();
        }

        return new RedirectResponse($this->getLoggedInRoute());
    }

    /**
     * LogoutPage
     */
    public function logoutPageAction()
    {
        return new HtmlResponse($this->templateRenderer->render('app::logout'));
    }

    /**
     * @return User
     */
    protected function getUserService()
    {
        return $this->user;
    }
}
