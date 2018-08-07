<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 13/05/2018
 * Time: 14:14
 */

namespace App\Security\Guard;

use App\Domain\Builder\Interfaces\UserBuilderInterface;
use App\Domain\Models\User;
use App\Domain\Repository\UserRepository;
use App\Services\Mailer;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\Provider\GoogleClient;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use League\OAuth2\Client\Provider\GoogleUser;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class GoogleAuthenticator extends SocialAuthenticator
{
    /**
     * @var ClientRegistry
     */
    private $clientRegistry;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var EncoderFactoryInterface
     */
    private $encoder;
    /**
     * @var UserBuilderInterface
     */
    private $userBuilder;
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;
    /**
     * @var FlashBagInterface
     */
    private $flashBag;
    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * GoogleAuthenticator constructor.
     * @param EncoderFactoryInterface $encoder
     * @param ClientRegistry          $clientRegistry
     * @param UserBuilderInterface    $userBuilder
     * @param UserRepository          $userRepository
     * @param UrlGeneratorInterface   $urlGenerator
     * @param FlashBagInterface       $flashBag
     * @param Mailer                  $mailer
     */
    public function __construct(
        EncoderFactoryInterface $encoder,
        ClientRegistry $clientRegistry,
        UserBuilderInterface $userBuilder,
        UserRepository $userRepository,
        UrlGeneratorInterface $urlGenerator,
        FlashBagInterface $flashBag,
        Mailer $mailer
    ) {
        $this->clientRegistry = $clientRegistry;
        $this->userRepository = $userRepository;
        $this->encoder        = $encoder;
        $this->userBuilder    = $userBuilder;
        $this->urlGenerator   = $urlGenerator;
        $this->flashBag       = $flashBag;
        $this->mailer         = $mailer;
    }

    /**
     * @return GoogleClient | \KnpU\OAuth2ClientBundle\Client\OAuth2Client
     */
    public function getGoogleClient()
    {
        return $this->clientRegistry
            // "google" is the key used in oauth2-client.yaml
            ->getClient('google');
    }

    /**
     * Returns a response that directs the user to authenticate.
     *
     * This is called when an anonymous request accesses a resource that
     * requires authentication. The job of this method is to return some
     * response that "helps" the user start into the authentication process.
     *
     * Examples:
     *  A) For a form login, you might redirect to the login page
     *      return new RedirectResponse('/login');
     *  B) For an API token authentication system, you return a 401 response
     *      return new Response('Auth header required', 401);
     *
     * @param Request                 $request       The request that resulted in an AuthenticationException
     * @param AuthenticationException $authException The exception that started the authentication process
     *
     * @return Response
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        // TODO: Implement start() method.
    }

    /**
     * Does the authenticator support the given Request?
     *
     * If this returns false, the authenticator will be skipped.
     *
     * @param Request $request
     *
     * @return bool
     */
    public function supports(Request $request)
    {
        // continue ONLY if the current ROUTE matches the check ROUTE
        return $request->attributes->get('_route') === 'social_google_check';
    }

    /**
     * Get the authentication credentials from the request and return them
     * as any type (e.g. an associate array).
     *
     * Whatever value you return here will be passed to getUser() and checkCredentials()
     *
     * For example, for a form login, you might:
     *
     *      return array(
     *          'username' => $request->request->get('_username'),
     *          'password' => $request->request->get('_password'),
     *      );
     *
     * Or for an API token that's on a header, you might use:
     *
     *      return array('api_key' => $request->headers->get('X-API-TOKEN'));
     *
     * @param Request $request
     *
     * @return mixed Any non-null value
     *
     * @throws \UnexpectedValueException If null is returned
     */
    public function getCredentials(Request $request)
    {
        // this method is only called if supports() returns true
        return $this->fetchAccessToken($this->getGoogleClient());
    }

    /**
     * Return a UserInterface object based on the credentials.
     *
     * The *credentials* are the return value from getCredentials()
     *
     * You may throw an AuthenticationException if you wish. If you return
     * null, then a UsernameNotFoundException is thrown for you.
     *
     * @param mixed                 $credentials
     * @param UserProviderInterface $userProvider
     *
     * @return UserInterface|null
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $encoder = $this->encoder->getEncoder(User::class);

        /** @var GoogleUser $googleUser */
        $googleUser = $this->getGoogleClient()
            ->fetchUserFromToken($credentials);

        $email = $googleUser->getEmail();

        // 1) have they logged in with Google before? Easy!
        $existingUser = $this->userRepository
            ->findOneBy(['googleId' => $googleUser->getId()]);
        if ($existingUser) {
            return $existingUser;
        }

        // 2) do we have a matching user by email?
        $user = $this->userRepository
            ->findOneBy(['email' => $email]);

        // 2b) complete the user infos with google account infos
        if ($user && !$existingUser) {
            $user->setGoogleId($googleUser->getId());

            null !== $user->getNickname() ? : "" === $googleUser->getName() ? : $user->setNickname($googleUser->getName());
            null !== $user->getFirstname() ? : "" === $googleUser->getFirstName() ? : $user->setFirstname($googleUser->getFirstName());
            null !== $user->getLastname() ? : "" === $googleUser->getLastName() ? : $user->setLastname($googleUser->getLastName());
            null !== $user->getImg() ? : $user->setImg($googleUser->getAvatar());

            $this->userRepository->register($user);
        }

        // 3) Maybe you just want to "register" them by creating a User object
        if (null === $user) {
            $this->userBuilder->createFromSocial(
                $googleUser->getEmail(),
                $googleUser->getId(),
                null,
                \Closure::fromCallable([$encoder, 'encodePassword']),
                $googleUser->getName(),
                $googleUser->getFirstName(),
                $googleUser->getLastName(),
                $googleUser->getAvatar(),
                100
            );

            $user = $this->userBuilder->getUser();

            $this->userRepository->register($user);

            // Send welcome mail
            $this->mailer->sendWelcome(
                $user
            );
        }

        return $user;
    }

    /**
     * Called when authentication executed, but failed (e.g. wrong username password).
     *
     * This should return the Response sent back to the user, like a
     * RedirectResponse to the login page or a 403 response.
     *
     * If you return null, the request will continue, but the user will
     * not be authenticated. This is probably not what you want to do.
     *
     * @param Request                 $request
     * @param AuthenticationException $exception
     *
     * @return Response|null
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $this->flashBag->add('login', $exception->getMessage());

        return new RedirectResponse($this->urlGenerator->generate('security_login'));
    }

    /**
     * Called when authentication executed and was successful!
     *
     * This should return the Response sent back to the user, like a
     * RedirectResponse to the last page they visited.
     *
     * If you return null, the current request will continue, and the user
     * will be authenticated. This makes sense, for example, with an API.
     *
     * @param Request        $request
     * @param TokenInterface $token
     * @param string         $providerKey The provider (i.e. firewall) key
     *
     * @return Response|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $this->flashBag->add('profile', 'Connecté');

        return new RedirectResponse($this->urlGenerator->generate('app_profile'));
    }
}