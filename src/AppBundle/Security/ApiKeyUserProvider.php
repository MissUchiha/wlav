<?php
/**
 * Created by PhpStorm.
 * User: uros
 * Date: 24.4.16.
 * Time: 12.06
 */

namespace AppBundle\Security;

use AppBundle\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;


class ApiKeyUserProvider implements UserProviderInterface
{
    protected $userRepo;

    // I'm injecting the Repo here (docs don't help with this)
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function loadUsernameForApiKey($apiKey)
    {
        // Look up the username based on the token in the database, via
        // an API call, or do something entirely different
        $username = $this->userRepo->getUserByApiKey($apiKey);

        return $username;
    }

    public function loadUserByUsername($username)
    {
        return $this->userRepo->getUserByUsername($username);
    }

    public function loadUserByUsernameAndPassword($username,$password)
    {
        return $this->userRepo->getUserByUsernameAndPassword($username,$password);
    }

    
    public function refreshUser(UserInterface $user)
    {
        // this is used for storing authentication in the session
        // but in this example, the token is sent in each request,
        // so authentication can be stateless. Throwing this exception
        // is proper to make things stateless
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return 'Symfony\Component\Security\Core\User\User' === $class;
    }
}