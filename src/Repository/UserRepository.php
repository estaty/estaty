<?php

namespace Estaty\Repository;

use Estaty\Model\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Gigablah\Silex\OAuth\Security\User\Provider\OAuthUserProviderInterface;
use Gigablah\Silex\OAuth\Security\Authentication\Token\OAuthTokenInterface;

class UserRepository extends EntityRepository implements UserProviderInterface, OAuthUserProviderInterface
{
    /**
     * Used automatically from the silex login process
     *
     * @param string $username
     * @return User|UserInterface
     * @throws UsernameNotFoundException
     */
    public function loadUserByUsername($username)
    {
        $user = $this->loadUserByEmail($username);

        if (null === $user) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }

        return $user;
    }

    /**
     * Used automatically from the silex login process
     *
     * @param $id
     * @return null|object
     */
    public function loadUserById($id)
    {
        return $this->findOneBy(array('id' => $id));
    }

    /**
     * Used automatically by silex on every new request
     *
     * @param UserInterface $user
     * @return User|UserInterface
     * @throws UnsupportedUserException
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$this->supportsClass(get_class($user))) {
            throw new UnsupportedUserException(sprintf(
                'Instances of "%s" are not supported.',
                get_class($user)
            ));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * Used automatically by silex
     *
     * @param string $class
     * @return bool
     */
    public function supportsClass($class)
    {
        return in_array($class, [
            'Estaty\Model\User',
            'Symfony\Component\Security\Core\User\User',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthCredentials(OAuthTokenInterface $token)
    {
        $user = $this->loadUserByEmail($token->getEmail());

        if (null === $user) {
            $user = $this->createUserFromOAuthToken($token);
        }

        $user->setOAuthServiceUid($token->getService(), $token->getUid());

        $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();

        return $user;
    }

    /**
     * @param  string $email
     * @return User|null
     */
    public function loadUserByEmail($email)
    {
        return $this->findOneBy(['email' => $email]);
    }

    /**
     * Create users from OAuth services automatically
     *
     * @param  OAuthTokenInterface $token
     * @return User
     */
    private function createUserFromOAuthToken(OAuthTokenInterface $token)
    {
        return new User(
            null,
            $token->getEmail(),
            null,
            $token->getUser(),
            ['ROLE_USER']
        );
    }
}
