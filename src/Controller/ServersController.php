<?php


namespace App\Controller;

use App\Entity\Servers;
use App\Form\ServerType;
use JJG\Ping;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/servers", name="servers_")
 */

class ServersController extends AbstractController
{
    /**
     * @Route("/", name="list")
     * @throws \Exception
     */
    public function index()
    {
        $servers = $this->getDoctrine()
            ->getRepository(Servers::class)
            ->findBy([], ['serverGroup' => 'ASC']);

        return $this->render('servers/index.html.twig', [
            'servers' => $servers
        ]);
    }


    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request)
    {
        $server = new Servers();
        $form = $this->createForm(ServerType::class, $server);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $server->setStatus(0);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($server);
            $entityManager->flush();

            $this->addFlash('notice', 'Serwer został dodany');

            return $this->redirectToRoute('servers_list');
        }


        return $this->render('servers/add_server.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Servers $server)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($server);
        $entityManager->flush();

        $this->addFlash('notice', 'Serwer został usunięty');

        return $this->redirectToRoute('servers_list');
    }


}