<?php

/**
 * RatingController class file
 *
 * PHP Version 7.1
 *
 * @category RatingController
 * @package  RatingController
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */

namespace App\Controller;

use App\Entity\Rating;
use App\Form\RatingType;
use App\Repository\RatingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * RatingController class
 *
 * The class holding the root RatingController class definition
 *
 * @category         RatingController
 * @package          RatingController
 * @author           HumanAid <contact.humanaid@gmail.com>
 * @license          http://opensource.org/licenses/gpl-license.php GPL
 * @link             http://example.com/
 * @Route("/rating")
 */
class RatingController extends AbstractController
{
    /**
     * Index Function
     *
     * @param RatingRepository $ratingRepository get rating repository
     *
     * @Route("/", name="rating_index", methods={"GET"})
     *
     * @return Response
     */
    public function index(RatingRepository $ratingRepository): Response
    {
        return $this->render(
            'rating/index.html.twig', [
            'ratings' => $ratingRepository->findAll(),
            ]
        );
    }

    /**
     * New Function
     *
     * @param Request $request get request params
     *
     * @Route("/new", name="rating_new", methods={"GET","POST"})
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        $rating = new Rating();
        $form = $this->createForm(RatingType::class, $rating);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$this->isCsrfTokenValid(
                'rating_item',
                $request->request->get('rating')['_token']
            )
            ) {
                throw new AccessDeniedException('Formulaire invalide');
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rating);
            $entityManager->flush();

            return $this->redirectToRoute('rating_index');
        }

        return $this->render(
            'rating/new.html.twig', [
            'rating' => $rating,
            'form' => $form->createView(),
            ]
        );
    }

    /**
     * Show Function
     *
     * @param Rating $rating get rating to show
     *
     * @Route("/{id}", name="rating_show", methods={"GET"})
     *
     * @return Response
     */
    public function show(Rating $rating): Response
    {
        return $this->render(
            'rating/show.html.twig', [
            'rating' => $rating,
            ]
        );
    }

    /**
     * Edit Function
     *
     * @param Request $request get request params
     * @param Rating  $rating  get rating to edit
     *
     * @Route("/{id}/edit", name="rating_edit", methods={"GET","POST"})
     *
     * @return Response
     */
    public function edit(Request $request, Rating $rating): Response
    {
        $form = $this->createForm(RatingType::class, $rating);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$this->isCsrfTokenValid(
                'rating_item',
                $request->request->get('rating')['_token']
            )
            ) {
                throw new AccessDeniedException('Formulaire invalide');
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rating_index');
        }

        return $this->render(
            'rating/edit.html.twig', [
            'rating' => $rating,
            'form' => $form->createView(),
            ]
        );
    }

    /**
     * Delete Function
     *
     * @param Request $request get request params
     * @param Rating  $rating  get rating to delete
     *
     * @Route("/{id}", name="rating_delete", methods={"DELETE"})
     *
     * @return Response
     */
    public function delete(Request $request, Rating $rating): Response
    {
        if ($this->isCsrfTokenValid(
            'delete'.$rating->getId(),
            $request->request->get('_token')
        )
        ) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rating);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rating_index');
    }
}
