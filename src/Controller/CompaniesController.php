<?php

namespace App\Controller;

use App\Entity\Companies;
use App\Form\CompanyType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/companies", name="companies_")
 */

class CompaniesController extends AbstractController
{

    /**
     * @Route("/", name="list")
     */
    public function index()
    {

        $companies = $this->getDoctrine()
            ->getRepository(Companies::class)
            ->findBy([], ['idCompany' => 'ASC']);

        return $this->render('companies/index.html.twig', [
            'companies' => $companies
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request)
    {
        $company = new Companies();
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($company);
            $entityManager->flush();

            $this->addFlash('notice', 'Spółka została dodana');

            return $this->redirectToRoute('companies_list');
        }

        return $this->render('companies/add_company.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Companies $company, Request $request)
    {
        $form = $this->createForm(CompanyType::class, $company, [
                'save_button_label' => 'Aktualizuj',
            ]
        );

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($company);
            $entityManager->flush();

            $this->addFlash('notice', 'Spółka została zedytowana');

            return $this->redirectToRoute('companies_list');
        }

        return $this->render('companies/edit_company.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
