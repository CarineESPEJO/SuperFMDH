<?php

namespace App\Controller\Users\Logs;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends AbstractController{
    #[Route('/login', name: 'login')]
    public function index(): Response {
        return $this->render('users/logs/login.html.twig', []);
    }
}