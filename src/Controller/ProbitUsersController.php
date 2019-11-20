<?php

namespace App\Controller;

use App\Entity\ProbitUsers;
use App\Form\ProbitUserType;
use App\Repository\ProbitUsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;


/**
 * @Route("/probit_users", name="probit_users_")
 */

class ProbitUsersController extends AbstractController
{
    /**
     * @Route("/", name="list")
     */
    public function index()
    {

        $probitUsers = $this->getDoctrine()
            ->getRepository(ProbitUsers::class)
            ->findBy([], ['number' => 'ASC']);

        return $this->render('probit_users/index.html.twig', [
            'probitUsers' => $probitUsers
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request)
    {
        $probitUser = new ProbitUsers();
        $form = $this->createForm(ProbitUserType::class, $probitUser);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($probitUser);
            $entityManager->flush();


            $this->addFlash('notice', 'Numer Probit został dodany');

            return $this->redirectToRoute('probit_users_list');
        }

        return $this->render('probit_users/add_probit_user.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(ProbitUsers $probitUser, Request $request)
    {
        $form = $this->createForm(ProbitUserType::class, $probitUser, [
                'save_button_label' => 'Aktualizuj',
                'validation_groups' => ['editprobituser']
            ]
        );

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($probitUser);
            $entityManager->flush();

            $this->addFlash('notice', 'Numer Probit został zedytowany');

            return $this->redirectToRoute('probit_users_list');
        }

        return $this->render('probit_users/edit_probit_user.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/clear/{id}", name="clear")
     */
    public function clear(ProbitUsers $probitUser)
    {
//        dd($probitUser);
        $probitUser->setName('');
        $probitUser->setSurname('');
        $probitUser->setLocalization('');

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        $this->addFlash('notice', 'Numer Probit został zwolniony');

        return $this->redirectToRoute('probit_users_list');
    }
}
