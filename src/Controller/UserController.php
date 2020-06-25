<?php

/**
 * UserController class file
 *
 * PHP Version 7.1
 *
 * @category UserController
 * @package  UserController
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */

namespace App\Controller;

use App\Entity\Address;
use App\Entity\User;
use App\Form\UserType;
use App\Form\UserEditType;
use App\Repository\UserRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * UserController class
 *
 * The class holding the root UserController class definition
 *
 * @category       UserController
 * @package        UserController
 * @author         HumanAid <contact.humanaid@gmail.com>
 * @license        http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link           http://example.com/
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * Index Function
     *
     * @param UserRepository $userRepository get user repository
     *
     * @Route("/", name="user_index", methods={"GET"})
     *
     * @return Response
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render(
            'user/index.html.twig', [
            'users' => $userRepository->findAll(),
            ]
        );
    }

    /**
     * New Function
     *
     * @param Request                      $request get request params
     * @param UserPasswordEncoderInterface $encoder get user password encoder
     *
     * @Route("/new", name="user_new", methods={"GET","POST"})
     *
     * @return Response
     * @throws Exception
     */
    public function new(
        Request $request, UserPasswordEncoderInterface $encoder
    ): Response {
        $form = $this->createForm(
            UserType::class, $user = new User(), [
                'method' => 'POST',
                'attr' => [
                    'id'     => 'new_user'
                ]
            ]
        )->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$this->isCsrfTokenValid(
                'user_item',
                $request->request->get('user')['_token']
            )
            ) {
                throw new AccessDeniedException('Formulaire invalide');
            }

            $user->setPassword(
                $encoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setRoles(
                [
                    $form->get('roles')->getData()
                ]
            );
            $user->setCreatedAt(new \DateTime());
            $user->setUpdatedAt(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();

            /**
             * Address
             *
             * @var Address $address
             */
            foreach ($form->get('addresses')->getData() as $address) {
                $user->addAddress($address);
                $address->setUser($user);
                $entityManager->persist($address);
            }

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render(
            'user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            ]
        );
    }

    /**
     * Show Function
     *
     * @param User $user get user to show
     *
     * @Route("/{id}", name="user_show", methods={"GET"})
     *
     * @return Response response
     */
    public function show(User $user): Response
    {
        return $this->render(
            'user/show.html.twig', [
            'user' => $user,
            ]
        );
    }

    /**
     * Edit Function
     *
     * @param Request                      $request get request params
     * @param User                         $user    get user to edit
     * @param UserPasswordEncoderInterface $encoder get user password encoder
     *
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     *
     * @return Response
     */
    public function edit(
        Request $request, User $user,
        UserPasswordEncoderInterface $encoder
    ): Response {
        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$this->isCsrfTokenValid(
                'user_edit_item',
                $request->request->get('user_edit')['_token']
            )
            ) {
                throw new AccessDeniedException('Formulaire invalide');
            }

            $em = $this->getDoctrine()->getManager();

            /**
             * Address
             *
             * @var Address $address
             */
            foreach ($form->get('addresses')->getData() as $address) {
                $user->addAddress($address);
                $address->setUser($user);
                $em->persist($address);
            }

            $em->flush();
            return $this->redirectToRoute('user_index');
        }

        return $this->render(
            'user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            ]
        );
    }

    /**
     * Delete Function
     *
     * @param Request $request get request params
     * @param User    $user    get user to delete
     *
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     *
     * @return Response
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid(
            'delete'.$user->getId(),
            $request->request->get('_token')
        )
        ) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
