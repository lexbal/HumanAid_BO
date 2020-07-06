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

use App\Entity\Event;
use App\Entity\User;
use App\Repository\EventRepository;
use App\Repository\UserRepository;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\LineChart;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
class HomeController extends AbstractController
{
    /**
     * Index Function
     *
     * @Route(
     *     "/",
     *     name="home"
     * )
     *
     * @return Response
     * @throws Exception
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        /** @var UserRepository $userRepo */
        $userRepo = $em->getRepository(User::class);
        /** @var EventRepository $eventRepo */
        $eventRepo = $em->getRepository(Event::class);

        $chart_data = [['Date de publication', 'Evenements']];

        foreach ($eventRepo->chart() as $row) {
            $chart_data[] = [
                new DateTime($row['date']), intval($row['total'])
            ];
        }

        $event_chart = $this->createChart(
            'Publication des évènements',
            $chart_data
        );

        $chart_data = [
            ['Date de publication', 'Associations', 'Entreprises', 'Utilisateurs']
        ];

        foreach ($userRepo->chart() as $row) {
            $chart_data[] = [
                new DateTime($row['date']),
                intval($row['assoc']),
                intval($row['company']),
                intval($row['user'])
            ];
        }

        $user_chart = $this->createChart(
            'Création de compte',
            $chart_data
        );

        return $this->render(
            'home.html.twig',
            [
                'events' => $eventRepo->countEvents(),
                'users' => $userRepo->countUsersTotal(),
                'past_events' => $eventRepo->findPastEvents(),
                'current_events' => $eventRepo->findCurrentEvents(),
                'future_events' => $eventRepo->findFutureEvents(),
                'event_chart' => $event_chart,
                'user_chart' => $user_chart,
                'user_detail' => $userRepo->countUsers()
            ]
        );
    }

    /**
     * Chart creation
     *
     * @param string $title get title
     * @param array  $data  get data
     *
     * @return LineChart
     */
    public function createChart($title, $data)
    {
        $event_chart = new LineChart();
        $event_chart->getData()->setArrayToDataTable($data);
        $event_chart->getOptions()->setTitle($title);
        $event_chart->getOptions()->getHAxis()->setFormat('dd MMM y');
        $event_chart->getOptions()->setCurveType('function');
        $event_chart->getOptions()->setLineWidth(4);

        return $event_chart;
    }
}
