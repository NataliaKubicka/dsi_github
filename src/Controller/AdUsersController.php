<?php


namespace App\Controller;


use App\Form\AdUserType;
use App\Utils\LdapDsi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdUsersController extends AbstractController
{
    /**
     * @Route("/search_ad_user_form", name="search_ad_user_form")
     */
    public function search(Request $request, LdapDsi $ldap)
    {
        $form = $this->createForm(AdUserType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $ldap_result = [];
            $search_value = '';
            if($form->get('username')->getData() != ""){
                $query = $ldap->getLdap()->query("DC=nt,DC=impel,DC=sa", '(sAMAccountName='.$form->get('username')->getData().'*)');
                $results = $query->execute();
                $search_value = $form->get('username')->getData();

                foreach ($results as $entries) {
                    $ldap_result[$entries->getAttribute('sAMAccountName')[0]] = [
                        'login' => $entries->getAttribute('sAMAccountName')[0],
                        'first_name' => $entries->getAttribute('givenName')[0],
                        'last_name' => $entries->getAttribute('sn')[0],
                        'company' => $entries->getAttribute('company')[0],
                        'directory_name' => $entries->getAttribute('distinguishedName')[0],
                        'email' => is_null($entries->getAttribute('mail')[0]) ? 'Brak' : $entries->getAttribute('mail')[0],
                        'city' => $entries->getAttribute('l')[0],
                        'address' => $entries->getAttribute('streetAddress')[0],
                        'office365' => 'NIE',
                        'mobile' => is_null($entries->getAttribute('telephoneNumber')[0]) ? 'Brak' : $entries->getAttribute('telephoneNumber')[0],
                    ];
                    if($entries->getAttribute('msExchRecipientTypeDetails')[0] == 2147483648 || $entries->getAttribute('msExchRecipientDisplayType')[0] == 6){
                        $ldap_result[$entries->getAttribute('sAMAccountName')[0]]['office365'] = 'TAK';
                    }
                }

            } elseif ($form->get('surname')->getData() != ""){

//                dd($form->get('surname')->getData());
                $query = $ldap->getLdap()->query("DC=nt,DC=impel,DC=sa", '(sn='.$form->get('surname')->getData().'*)');
                $results = $query->execute();
                $search_value = $form->get('surname')->getData();

                foreach ($results as $entries) {
                    $ldap_result[$entries->getAttribute('sAMAccountName')[0]] = [
                        'login' => is_null($entries->getAttribute('sAMAccountName')[0]) ? 'Brak' : $entries->getAttribute('sAMAccountName')[0],
                        'first_name' => $entries->getAttribute('givenName')[0],
                        'last_name' => $entries->getAttribute('sn')[0],
                        'company' => $entries->getAttribute('company')[0],
                        'directory_name' => $entries->getAttribute('distinguishedName')[0],
                        'email' => is_null($entries->getAttribute('mail')[0]) ? 'Brak' : $entries->getAttribute('mail')[0],
                        'city' => $entries->getAttribute('l')[0],
                        'address' => $entries->getAttribute('streetAddress')[0],
                        'office365' => 'NIE',
                        'mobile' => is_null($entries->getAttribute('telephoneNumber')[0]) ? 'Brak' : $entries->getAttribute('telephoneNumber')[0],
                    ];
                    if($entries->getAttribute('msExchRecipientTypeDetails')[0] == 2147483648 || $entries->getAttribute('msExchRecipientDisplayType')[0] == 6){
                        $ldap_result[$entries->getAttribute('sAMAccountName')[0]]['office365'] = 'TAK';
                    }
                }
            }

            return $this->render(
                'ad_users/ad_users_result.html.twig',
                [
                    'results' => $ldap_result,
                    'search' => $search_value,
                ]
            );

        }

        return $this->render('ad_users/ad_users_search_form.html.twig', [
            'form' => $form->createView()
        ]);
    }


}
