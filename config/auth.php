<?php

use Estaty\Model\User;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Gigablah\Silex\OAuth\OAuthServiceProvider;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;

if (file_exists(__DIR__.'/secret/auth.'.$app['env'].'.php')) {
    include __DIR__.'/secret/auth.'.$app['env'].'.php';
} else {
    include __DIR__.'/secret/auth.php';
}

if (file_exists(__DIR__.'/secret/form.'.$app['env'].'.php')) {
    include __DIR__.'/secret/form.'.$app['env'].'.php';
} else {
    include __DIR__.'/secret/form.php';
}

$app->register(new OAuthServiceProvider(), [
    'oauth.services' => [
        User::FACEBOOK => [
            'key' => FACEBOOK_APP_ID,
            'secret' => FACEBOOK_APP_SECRET,
            'scope' => ['email'],
            'user_endpoint' => 'https://graph.facebook.com/me',
        ],
        User::GOOGLE => array(
            'key' => GOOGLE_OAUTH_CLIENT_ID,
            'secret' => GOOGLE_OAUTH_CLIENT_SECRET,
            'scope' => array(
                'https://www.googleapis.com/auth/userinfo.email',
                'https://www.googleapis.com/auth/userinfo.profile'
            ),
            'user_endpoint' => 'https://www.googleapis.com/oauth2/v1/userinfo'
        ),
        User::GITHUB => [
            'key' => GITHUB_OAUTH_CLIENT_ID,
            'secret' => GITHUB_OAUTH_CLIENT_SECRET,
            'scope' => ['user:email'],
            'user_endpoint' => 'https://api.github.com/user',
            'class' => 'OAuth\OAuth2\Service\GitHub',
        ],
    ],
]);

// Provides CSRF token generation
$app->register(new FormServiceProvider(), [
    'form.secret' => FORM_SECRET,
]);

// Provides session storage
$app->register(new SessionServiceProvider(), [
    'session.storage.save_path' => sys_get_temp_dir(),
]);

$app->register(new SecurityServiceProvider(), [
    'security.firewalls' => [
        'default' => [
            'pattern' => '^/',
            'anonymous' => true,
            'oauth' => [
                // These are the defaults and are generated
                // 'login_path' => '/auth/{service}',
                // 'callback_path' => '/auth/{service}/callback',
                // 'check_path' => '/auth/{service}/check',
                'failure_path' => '/login',
                'with_csrf' => true
            ],
            'logout' => [
                'logout_path' => '/logout',
                'with_csrf' => true
            ],
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
            'users' => $app->share(function($app) {
                /** @var \Doctrine\ORM\EntityManager $orm */
                $orm = $app['orm.em'];

                return $orm->getRepository('\Estaty\Model\User');
            }),
        ],
    ],
    'security.role_hierarchy' => [
        'ROLE_ADMIN' => ['ROLE_USER', 'ROLE_ALLOWED_TO_SWITCH'],
    ],
]);

$app['security.encoder.digest'] = $app->share(function() {
    return new BCryptPasswordEncoder(10);
});
