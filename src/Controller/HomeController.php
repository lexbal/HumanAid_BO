<?php

/**
 * HomeController class file
 *
 * PHP Version 7.1
 *
 * @category HomeController
 * @package  HomeController
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;

/**
 * HomeController class
 *
 * The class holding the root HomeController class definition
 *
 * @category   HomeController
 * @package    HomeController
 * @author     HumanAid <contact.humanaid@gmail.com>
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link       http://example.com/
 * @Route("/")
 */
class HomeController
{
    /**
     * Index Function
     *
     * @Route(
     *     "/",
     *     name="home"
     * )
     * @Template("base.html.twig")
     *
     * @return array
     */
    public function index()
    {
        return [];
    }
}