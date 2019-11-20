<?php


namespace App\Controller;


use App\Entity\Role;
use App\Entity\Users;
use App\Form\UserType;
use App\Service\CreateUserAccountService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 * @Route("/users", name="users_")
 */
class UsersController extends AbstractController
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/", name="list")
     */
    public function index()
    {
        $users = $this->getDoctrine()
            ->getRepository(Users::class)
            ->findAll();

        return $this->render('users/index.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request)
    {
        $defaultRole = $this->getDoctrine()->getManager()->getRepository(Role::class)->findOneBy(['name' => 'ROLE_USER']);
        $user = new Users();
        $user->setUserRole($defaultRole);
        $form = $this->createForm(UserType::class, $user, [
            'validation_groups' => ['addUser']
            ]
        );

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $createUserAccountService = new CreateUserAccountService($user, $this->getDoctrine()->getManager(), $this->passwordEncoder);
            $createUserAccountService->createUser();

            $this->addFlash('notice', 'Użytkownik został dodany');

            return $this->redirectToRoute('users_list');
        }

        return $this->render('users/add_user.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Users $user, Request $request)
    {
        $form = $this->createForm(UserType::class, $user, [
                'save_button_label' => 'Aktualizuj użytkownika',
                'validation_groups' => ['editUser']
            ]
        );

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('notice', 'Użytkownik został zaktualizowany');

            return $this->redirectToRoute('users_list');

        }

        return $this->render('users/edit_user.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
