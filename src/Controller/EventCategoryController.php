<?php

/**
 * EventCategoryController class file
 *
 * PHP Version 7.1
 *
 * @category EventCategoryController
 * @package  EventCategoryController
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */

namespace App\Controller;

use App\Entity\EventCategory;
use App\Form\EventCategoryType;
use App\Repository\EventCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * EventCategoryController class
 *
 * The class holding the root EventCategoryController class definition
 *
 * @category EventCategoryController
 * @package  EventCategoryController
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 *
 * @Route("/eventcategory")
 */

class EventCategoryController extends AbstractController
{
    /**
     * Index Function
     *
     * @param EventCategoryRepository $eventCategoryRepository 
     * get event category repository
     *
     * @Route("/", name="eventcategory_index", methods={"GET"})
     *
     * @return Response
     */
    public function index(EventCategoryRepository $eventCategoryRepository): Response
    {
        return $this->render(
            'event_category/index.html.twig',
            [
                'eventcategories' => $eventCategoryRepository->findAll(),
            ]
        );
    }

        /**
     * New Function
     *
     * @param Request $request get request params
     *
     * @Route("/new", name="eventcategory_new", methods={"GET","POST"})
     *
     * @return Response
     * @throws \Exception
     */
    public function new(Request $request): Response
    {
        $form  = $this->createForm(EventCategoryType::class, $eventCategory = new EventCategory());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($eventCategory);
            $entityManager->flush();

            return $this->redirectToRoute('eventcategory_index');
        }

        return $this->render(
            'event_category/new.html.twig',
            [
                'eventCategory' => $eventCategory,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Show Function
     *
     * @param EventCategory $eventCategory get eventCategory to show
     *
     * @Route("/{id}", name="eventcategory_show", methods={"GET"})
     *
     * @return Response
     */
    public function show(EventCategory $eventCategory): Response
    {
        return $this->render(
            'event_category/show.html.twig',
            [
                'eventCategory' => $eventCategory,
            ]
        );
    }

    /**
     * Edit Function
     *
     * @param Request $request get request params
     * @param EventCategory   $eventCategory   get eventCategory to edit
     *
     * @Route("/{id}/edit", name="eventcategory_edit", methods={"GET","POST"})
     *
     * @return Response
     */
    public function edit(Request $request, EventCategory $eventCategory): Response
    {
        $form = $this->createForm(EventCategoryType::class, $eventCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('eventcategory_index');
        }

        return $this->render(
            'event_category/edit.html.twig',
            [
                'eventCategory' => $eventCategory,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Delete Function
     *
     * @param Request $request get request params
     * @param EventCategory   $eventCategory   get eventCategory to delete
     *
     * @Route("/{id}/delete", name="eventcategory_delete")
     *
     * @return Response
     */
    public function delete(Request $request, EventCategory $eventCategory): Response
    {
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($eventCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('eventcategory_index');
    }
}

