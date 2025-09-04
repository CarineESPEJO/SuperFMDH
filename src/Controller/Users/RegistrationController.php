<?php

namespace App\Controller\Users;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends AbstractController{
    #[Route('/registration', name: 'registration')]
    public function index(): Response {
        return $this->render('users/registration.html.twig', []);
    }
}