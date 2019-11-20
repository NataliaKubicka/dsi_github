<?php


namespace App\Controller;


use App\Form\AdGroupType;
use App\Utils\LdapDsi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdGroupsController extends AbstractController
{
    /**
     * @Route("/search_ad_group_form", name="search_ad_group_form")
     */
    public function search(Request $request, LdapDsi $ldap)
    {
        $form = $this->createForm(AdGroupType::class, [
                'save_button_label' => 'Aktualizuj',
                'validation_groups' => ['editcompany']
            ]
        );

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $ldap_result = [];
            $query = $ldap->getLdap()->query("DC=nt,DC=impel,DC=sa", '(&(objectcategory=group)(cn='.$form->get('groupName')->getData().'*))');
            $search_value = $form->get('groupName')->getData();

            $results = $query->execute();

            foreach ($results as $entries) {
                $ldap_result[$entries->getAttribute('distinguishedName')[0]] = [];

                foreach($entries->getAttribute('member') as $member){
                    $dnTable = explode(',', $member);
                    $cnTable = explode('=', $dnTable[0]);
                    $cnTable[1] = str_replace(['(', ')'], ['', ''], $cnTable[1]);
                    $query2 = $ldap->getLdap()->query("DC=nt,DC=impel,DC=sa", '(&(objectclass=user)(cn='.$cnTable[1].'))');
                    $results2 = $query2->execute();

                    foreach($results2 as $entries2){
                        $ldap_result[$entries->getAttribute('distinguishedName')[0]][] = [
                            'dn' => $entries2->getAttribute('distinguishedName')[0],
                            'name' => $entries2->getAttribute('displayName')[0],
                            'company' => $entries2->getAttribute('company')[0],
                        ];
                    }
                }
            }

            return $this->render(
                'ad_groups/ad_groups_result.html.twig',
                [
                    'results' => $ldap_result,
                    'search' => $search_value,
                ]
            );
        }

        return $this->render('ad_groups/ad_groups_search_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

}