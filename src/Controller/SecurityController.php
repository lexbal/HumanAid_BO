<?php

/**
 * SecurityController class file
 *
 * PHP Version 7.1
 *
 * @category SecurityController
 * @package  SecurityController
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


/**
 * SecurityController class
 *
 * The class holding the root SecurityController class definition
 *
 * @category SecurityController
 * @package  SecurityController
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */
class SecurityController extends AbstractController
{
    /**
     * Login Function
     *
     * @param AuthenticationUtils $authenticationUtils get authenticationUtils
     *
     * @Route("/login", name="app_login")
     *
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'security/login.html.twig', [
                'last_username' => $lastUsername,
                'error' => $error
            ]
        );
    }

    /**
     * Logout Function
     *
     * @Route("/logout", name="app_logout")
     *
     * @return void
     * @throws \Exception
     */
    public function logout()
    {
        throw new \Exception(
            'This method can be blank - '.
            'it will be intercepted by the logout key on your firewall'
        );
    }
}
