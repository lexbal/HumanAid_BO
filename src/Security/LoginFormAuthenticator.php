<?php

/**
 * LoginFormAuthenticator class file
 *
 * PHP Version 7.1
 *
 * @category LoginFormAuthenticator
 * @package  LoginFormAuthenticator
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\{
    RedirectResponse, Request
};
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\{
    CustomUserMessageAuthenticationException,
    InvalidCsrfTokenException
};
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\{
    UserInterface, UserProviderInterface
};
use Symfony\Component\Security\Csrf\{
    CsrfToken, CsrfTokenManagerInterface
};
use Symfony\Component\Security\Guard\{
    Authenticator\AbstractFormLoginAuthenticator,
    PasswordAuthenticatedInterface
};
use Symfony\Component\Security\Http\Util\TargetPathTrait;

/**
 * LoginFormAuthenticator class
 *
 * The class holding the root LoginFormAuthenticator class definition
 *
 * @category LoginFormAuthenticator
 * @package  LoginFormAuthenticator
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */
class LoginFormAuthenticator
    extends AbstractFormLoginAuthenticator
    implements PasswordAuthenticatedInterface
{
    use TargetPathTrait;

    private $_entityManager;
    private $_urlGenerator;
    private $_csrfTokenManager;
    private $_passwordEncoder;

    /**
     * LoginFormAuthenticator constructor.
     *
     * @param EntityManagerInterface       $entityManager    entityManager
     * @param UrlGeneratorInterface        $urlGenerator     urlGenerator
     * @param CsrfTokenManagerInterface    $csrfTokenManager csrfTokenManager
     * @param UserPasswordEncoderInterface $passwordEncoder  passwordEncoder
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        UrlGeneratorInterface $urlGenerator,
        CsrfTokenManagerInterface $csrfTokenManager,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->_entityManager    = $entityManager;
        $this->_urlGenerator     = $urlGenerator;
        $this->_csrfTokenManager = $csrfTokenManager;
        $this->_passwordEncoder  = $passwordEncoder;
    }

    /**
     * Support
     *
     * @param Request $request request
     *
     * @return bool
     */
    public function supports(Request $request)
    {
        return 'app_login' === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    /**
     * Get Credentials
     *
     * @param Request $request request
     *
     * @return array|mixed
     */
    public function getCredentials(Request $request)
    {
        $credentials = [
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['email']
        );

        return $credentials;
    }

    /**
     * Get User
     *
     * @param mixed                 $credentials  credentials
     * @param UserProviderInterface $userProvider userProvider
     *
     * @return object|UserInterface|null
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
        if (!$this->_csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }

        $user = $this->_entityManager->getRepository(User::class)
            ->findOneBy(['email' => $credentials['email']]);

        if (!$user) {
            // fail authentication with a custom error
            throw new CustomUserMessageAuthenticationException(
                'Email could not be found.'
            );
        }

        return $user;
    }

    /**
     * Check Credentials
     *
     * @param mixed         $credentials credentials
     * @param UserInterface $user        user
     *
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        return $this->_passwordEncoder->isPasswordValid(
            $user,
            $credentials['password']
        );
    }

    /**
     * Get Password
     *
     * @param mixed $credentials credentials
     *
     * @return string|null
     */
    public function getPassword($credentials): ?string
    {
        return $credentials['password'];
    }

    /**
     * On Authentication Success
     *
     * @param Request        $request     request
     * @param TokenInterface $token       token
     * @param string         $providerKey provider key
     *
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response|null
     */
    public function onAuthenticationSuccess(
        Request $request, TokenInterface $token,
        $providerKey
    ) {
        if ($targetPath = $this->getTargetPath(
            $request->getSession(), $providerKey
        )
        ) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->_urlGenerator->generate('home'));
    }

    /**
     * Get Login Url
     *
     * @return string
     */
    protected function getLoginUrl()
    {
        return $this->_urlGenerator->generate('app_login');
    }
}
