<?php

namespace Estaty\Controller;

use Estaty\Model\User;
use Estaty\Application;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class AuthController
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param  Symfony\Component\HttpFoundation\Request $request
     * @return string response with Login/Signup form
     */
    public function loginForm(Request $request)
    {
        $user = $this->getEmptyUser();

        return $this->getLoginFormResponse($user);
    }

    public function loginOrSignupCheck(Request $request)
    {
        $user = $this->getEmptyUser();

        $loginSignupForm = $this->getLoginSignupForm($user);

        $loginSignupForm->handleRequest($request);

        if ($loginSignupForm->get('login')->isClicked()) {
            return $this->getLoginCheckResponse($request);
        }

        if ($loginSignupForm->get('signup')->isClicked()) {
            return $this->createUser($request);
        }

        return $this->getLoginCheckResponse($request);
    }

    public function createUser(Request $request)
    {
        $user = $this->getEmptyUser();
        $signupForm = $this->getLoginSignupForm($user);
        $signupForm->handleRequest($request);

        if (!$signupForm->isValid()) {
            return $this->getLoginFormResponse($user, $signupForm);
        }

        /**
         * @var Estaty\User
         */
        $user = $signupForm->getData();

        $encodedPassword = $this->app->encodePassword($user, $user->getPassword());
        $user->setPassword($encodedPassword);
        $user->setRoles(['ROLE_USER']);

        /**
         * @var Doctrine\ORM\EntityManager
         */
        $em = $this->app['orm.em'];

        $em->persist($user);
        $em->flush();

        // Log in the new user
        $token = new UsernamePasswordToken($user, null, 'default', $user->getRoles());
        $this->app['security']->setToken($token);

        return $this->app->redirect($this->app->path('login'));
    }

    private function getLoginFormResponse(User $user, Form $loginSignupForm = null)
    {
        $services = array_keys($this->app['oauth.services']);

        if (null === $loginSignupForm) {
            $loginSignupForm = $this->getLoginSignupForm($user);
        }

        return $this->app['twig']->render('login.twig', array(
            'login_paths' => array_map(function ($service) {
                return $this->app['url_generator']->generate('_auth_service', array(
                    'service' => $service,
                    '_csrf_token' => $this->app['form.csrf_provider']->generateCsrfToken('oauth')
                ));
            }, array_combine($services, $services)),
            'logout_path' => $this->app['url_generator']->generate('logout', array(
                '_csrf_token' => $this->app['form.csrf_provider']->generateCsrfToken('logout')
            )),
            'error' => $this->app['security.last_error']($this->app['request']),
            'loginSignupForm' => $loginSignupForm->createView(),
        ));
    }

    private function getLoginSignupForm(User $user)
    {
        $loginSignupForm = $this->app['form.factory']->createNamedBuilder(null, 'form', $user)
            ->setAction($this->app->path('loginOrSignupCheck'))
            ->add('email', 'text', ['label' => 'Email'])
            ->add('password', 'password')
            ->add('login', 'submit', ['label' => 'Log in'])
            ->add('name', 'text', ['label' => 'Name', 'required' => false])
            ->add('signup', 'submit', ['label' => 'Sign up'])
            ->getForm();

        return $loginSignupForm;
    }

    private function getLoginCheckResponse(Request $request)
    {
        $loginRequest = Request::create(
            $this->app->path('login_check'),
            'POST',
            [
                '_username' => $request->get('email'),
                '_password' => $request->get('password'),
            ],
            $request->cookies->all(),
            [],
            $request->server->all()
        );

        $response = $this->app->handle(
            $loginRequest,
            HttpKernelInterface::MASTER_REQUEST,
            false
        );

        return $response;
    }

    private function getEmptyUser()
    {
        return new User(null, $this->app['session']->get('_security.last_username'), null, null);
    }
}
