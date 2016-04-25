<?php
namespace AppBundle\Security;

use AppBundle\AppBundle;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;

class ApiKeyAuthenticator implements SimplePreAuthenticatorInterface, AuthenticationFailureHandlerInterface
{
    private $logger;

    public function __construct($logger)
    {
        $this->logger = $logger;
    }

    public function createToken(Request $request, $providerKey)
    {
        // look for an apikey query parameter
        $apiKey = (isset($_GET['apikey'])) ? $_GET['apikey'] : false;

        // or if you want to use an "apikey" header, then do something like this:
        // $apiKey = $request->headers->get('apikey');

        if($apiKey)
        {
            return new PreAuthenticatedToken(
                'anon.',
                $apiKey,
                $providerKey
            );
        }
        else
        {
            $user = new User();
            $username = (isset($_GET['username'])) ? $_GET['username'] : false;
            $password = (isset($_GET['password'])) ? $_GET['password'] : false;
            $user->setUsername($username);
            $user->setPassword($password);

            return new PreAuthenticatedToken(
                $user,
                $apiKey,
                $providerKey
            );
        }
    }

    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {
        if (!$userProvider instanceof ApiKeyUserProvider) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The user provider must be an instance of ApiKeyUserProvider (%s was given).',
                    get_class($userProvider)
                )
            );
        }

        $apiKey = $token->getCredentials();
        $user = $token->getUser();

        // AKo je poslat token, korisnik je bio ulogovan i ostaje ulogovan
        if($apiKey)
        {

            $this->logger->info("==============================================================================");
            $this->logger->info("Imam API Key");
            $this->logger->info("==============================================================================");
            $authUser = $userProvider->loadUserByApiKey($apiKey);

            if( !$authUser ) {
                return new PreAuthenticatedToken(
                    'anon.1',
                    $apiKey,
                    $providerKey
                );
                //throw new BadCredentialsException('No API key found');
            }

            return new PreAuthenticatedToken(
                $authUser,
                $apiKey,
                $providerKey,
                $authUser->getRoles()
            );
        }
        // AKo nije poslat token, korisnik se prvi put loguje
        else
        {
            $this->logger->info("==============================================================================");
            $this->logger->info("Nemam API Key");
            // Ovo nije pravi objekat usera, nego samo username i password
            $noAuthUser = $token->getUser();

            if( !$noAuthUser->getUsername() ) {
                $this->logger->info("Anonimno logovanje (nije prosledjen username i password)");
                return new PreAuthenticatedToken(
                    'anon.3',
                    $apiKey,
                    $providerKey
                );
            }

            $this->logger->info("Imamo username i password");
            $authUser = $userProvider->loadUserByUsernameAndPassword($noAuthUser->getUsername(),$noAuthUser->getPassword());

            if(!$authUser) {
                $this->logger->info("Nismo nasli korisnika: anonimno logovanje(anon.4)");
                return new PreAuthenticatedToken(
                'anon.4',
                $apiKey,
                $providerKey
                 );
            }

            $this->logger->info("Nasli smo korisnika: " . $authUser->getUsername());
            $this->logger->info(print_r($authUser, true));
            $this->logger->info("==============================================================================");
            return new UsernamePasswordToken(
                $authUser,
                $authUser->getApiKey(),
                $providerKey,
                $authUser->getRoles()
            );
        }
    }

    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }

    public function refreshUser(UserInterface $user)
    {
        // $user is the User that you set in the token inside authenticateToken()
        // after it has been deserialized from the session

        // you might use $user to query the database for a fresh user

        // use $id to make a query

        // if you are *not* reading from a database and are just creating
        // a User object (like in this example), you can just return it

        return $user;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new Response(
        // this contains information about *why* authentication failed
        // use it, or return your own message
            strtr($exception->getMessageKey(), $exception->getMessageData()),
            403
        );
    }
}