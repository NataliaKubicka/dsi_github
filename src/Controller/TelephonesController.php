<?php


namespace App\Controller;


use App\Form\TelephonesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TelephonesController extends AbstractController
{
    /**
     * @Route("/search_telephones_form", name="search_telephones_form")
     */
    public function search(Request $request)
    {
        $form = $this->createForm(TelephonesType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $customerEntityManager = $this->getDoctrine()->getManager('biling_tel');
            $search_value = '';
            $ushersPhones = '';

            if ($data['telephone']) {
                $RAW_QUERY = "SELECT * FROM dsitools_wyszukiwanie_tel WHERE telefon = :telefon";
                $statement = $customerEntityManager->getConnection()->prepare($RAW_QUERY);
                $statement->bindValue('telefon', $data['telephone']);
                $search_value = $form->get('telephone')->getData();
                $statement->execute();
                $ushersPhones = $statement->fetchAll();

            } elseif ($data['surname']) {
                $RAW_QUERY = "SELECT * FROM dsitools_wyszukiwanie_tel WHERE uzytkownik LIKE :surname";
                $statement = $customerEntityManager->getConnection()->prepare($RAW_QUERY);
                $statement->bindValue('surname', '%'.$data['surname'].'%');
                $search_value = $form->get('surname')->getData();
                $statement->execute();
                $ushersPhones = $statement->fetchAll();
            }

            return $this->render('telephones/telephones_result.html.twig', [
                'ushersPhones' => $ushersPhones,
                'search' => $search_value,
            ]);

        }

        return $this->render('telephones/telephones_search_form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
