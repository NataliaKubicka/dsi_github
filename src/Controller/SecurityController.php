<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\ChangePasswordType;
use App\Form\RecoveryPasswordType;
use App\Service\UserService;
use App\Utils\Messages;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    /**
     * @Route("/login", name="security_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {

        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            // redirect authenticated users to homepage

            return $this->redirectToRoute('servers_list');
        }


        return $this->render('auth/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    /**
     * @Route("/recovery", name="recovery", methods={"GET", "POST"})
     */
    public function recoverPassword(Request $request) {
        $form = $this->createForm(RecoveryPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->sendPasswordRecoveryEmail($form);
            return $this->redirectToRoute('recovery');
        }

        return $this->render('auth/recovery_password.html.twig', [
            'form' => $form->createView(),
            'errors' => $form->getErrors()
        ]);
    }

    /**
     * @Route("/recovery/confirm/{token}", name="recovery_confirm", methods={"GET", "POST"})
     */
    public function recoverPasswordCheck(Request $request, string $token) {
        $user = $this->userService->getUserByToken($token);

        if (!$token || !$user instanceof Users) {
            $this->addFlash('danger', Messages::EMAIL_TOKEN_EXPIRED);
            return $this->redirectToRoute('recovery');
        }

        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->setNewPassword($user, $form);
            return $this->redirectToRoute('security_login');
        }

        return $this->render('auth/change_password.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout()
    {

    }
}
