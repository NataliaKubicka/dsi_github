<?php

namespace App\Controller;

use App\Entity\Ups;
use App\Form\UpsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/ups", name="ups_")
 */
class UpsController extends AbstractController
{

    /**
     * @Route("/", name="list")
     */
    public function index()
    {

        $ups = $this->getDoctrine()
            ->getRepository(Ups::class)
            ->findAll();

        return $this->render('ups/index.html.twig', [
            'ups' => $ups
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request)
    {
        $ups = new Ups();
        $form = $this->createForm(UpsType::class, $ups);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ups);
            $entityManager->flush();

            $this->addFlash('notice', 'UPS został dodany');

            return $this->redirectToRoute('ups_list');
        }

        return $this->render('ups/add_ups.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Ups $ups, Request $request)
    {
        $form = $this->createForm(UpsType::class, $ups, [
                'save_button_label' => 'Aktualizuj',
            ]
        );

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ups);
            $entityManager->flush();

            $this->addFlash('notice', 'UPS został zedytowany');

            return $this->redirectToRoute('ups_list');
        }

        return $this->render('ups/edit_ups.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Ups $ups)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($ups);
        $entityManager->flush();

        $this->addFlash('notice', 'UPS został usunięty');

        return $this->redirectToRoute('ups_list');
    }
}
