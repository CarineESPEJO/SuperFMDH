<?php

namespace App\Controller\Users\Logs;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login', methods: ['GET', 'POST'])]
    public function login(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $errors = [];

        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            /** @var User|null $user */
            $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);

            if (!$user) {
                $errors['general'] = "Aucun utilisateur trouvé avec cet email.";
            } elseif (!$passwordHasher->isPasswordValid($user, $password)) {
                $errors['general'] = "Mot de passe incorrect.";
            } else {
                // Log in via Symfony session
                $session = $request->getSession();
                $session->set('userId', $user->getId());

                // You can also manually authenticate via Symfony security if needed
                return $this->redirectToRoute('home');
            }
        }

        return $this->render('users/logs/login.html.twig', [
            'errors' => $errors,
        ]);
    }
}
