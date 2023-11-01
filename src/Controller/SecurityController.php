<?php

namespace App\Controller;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/register', name: 'app_register')]
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $email = $request->request->get('email');
        $plainPassword = $request->request->get('password');

        $user->setEmail($email);
        
        $hashedPassword = $passwordEncoder->encodePassword($user, $plainPassword);
        $user->setPassword($hashedPassword);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('logged');
    }

    public function logged(): Response
    {
        return $this->render('/logged.html.twig');
    }

}
