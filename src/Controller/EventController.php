<?php

/**
 * EventController class file
 *
 * PHP Version 7.1
 *
 * @category EventController
 * @package  EventController
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */

namespace App\Controller;

use App\Entity\Event;
use App\Entity\EventCategory;
use App\Form\EventType;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * EventController class
 *
 * The class holding the root EventController class definition
 *
 * @category EventController
 * @package  EventController
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 *
 * @Route("/event")
 */
class EventController extends AbstractController
{
    /**
     * Index Function
     *
     * @param EventRepository $eventRepository get event repository
     *
     * @Route("/", name="event_index", methods={"GET"})
     *
     * @return Response
     */
    public function index(EventRepository $eventRepository): Response
    {
        return $this->render(
            'event/index.html.twig',
            [
                'events' => $eventRepository->findAll(),
            ]
        );
    }

    /**
     * New Function
     *
     * @param Request $request get request params
     *
     * @Route("/new", name="event_new", methods={"GET","POST"})
     *
     * @return Response
     * @throws \Exception
     */
    public function new(Request $request): Response
    {
        $form  = $this->createForm(EventType::class, $event = new Event());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$this->isCsrfTokenValid(
                'event_item',
                $request->request->get('event')['_token']
            )
            ) {
                throw new AccessDeniedException('Formulaire invalide');
            }

            $entityManager = $this->getDoctrine()->getManager();

            /**
             * Event category
             *
             * @var EventCategory $category
             */
            foreach ($form->get('categories')->getData() as $category) {
                $event->addCategory($category);
            }

            $event->setPublishDate(new \DateTime());
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('event_index');
        }

        return $this->render(
            'event/new.html.twig',
            [
                'event' => $event,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Show Function
     *
     * @param Event $event get event to show
     *
     * @Route("/{id}", name="event_show", methods={"GET"})
     *
     * @return Response
     */
    public function show(Event $event): Response
    {
        return $this->render(
            'event/show.html.twig',
            [
                'event' => $event,
            ]
        );
    }

    /**
     * Edit Function
     *
     * @param Request $request get request params
     * @param Event   $event   get event to edit
     *
     * @Route("/{id}/edit", name="event_edit", methods={"GET","POST"})
     *
     * @return Response
     */
    public function edit(Request $request, Event $event): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$this->isCsrfTokenValid(
                'event_item',
                $request->request->get('event')['_token']
            )
            ) {
                throw new AccessDeniedException('Formulaire invalide');
            }
            
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_index');
        }

        return $this->render(
            'event/edit.html.twig',
            [
                'event' => $event,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Delete Function
     *
     * @param Request $request get request params
     * @param Event   $event   get event to delete
     *
     * @Route("/{id}", name="event_delete", methods={"DELETE"})
     *
     * @return Response
     */
    public function delete(Request $request, Event $event): Response
    {
        if ($this->isCsrfTokenValid(
            'delete'.$event->getId(),
            $request->request->get('_token')
        )
        ) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('event_index');
    }
}
