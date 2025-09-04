<?php

namespace App\Controller\Users\Logs;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class LogController extends AbstractController{
    #[Route('/login', name: 'login')]
    public function login(): Response {
        return $this->render('users/logs/login.html.twig', []);
    }

     #[Route('/logout', name: 'logout')]
    public function logout(): Response {
        return $this->render('users/logs/logout.html.twig', []);
    }
}