<?php


namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller
 * @Route("/")
 */
class HomeController
{
    /**
     * @Route("/", name="home")
     * @Template("base.html.twig")
     * @return array
     */
    public function index()
    {
        return [];
    }
}