<?php

namespace App\Controller\Users\Logs;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class LogoutController extends AbstractController{
    #[Route('/logout', name: 'logout')]
    public function index(): Response {
        return $this->render('users/logs/logout.html.twig', []);
    }
}