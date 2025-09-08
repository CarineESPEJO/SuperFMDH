<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    public function index(): Response
    {
        // Example logic
        $isLoggedIn = $this->getUser() !== null;
        $userRole = $isLoggedIn ? $this->getUser()->getRoles()[0] : null;
        $userEmail = $isLoggedIn ? $this->getUser()->getUserIdentifier() : null;

        return $this->render('base.html.twig', [
            'isLoggedIn' => $isLoggedIn,
            'userId' => $isLoggedIn,
            'userRole' => $userRole,
            'userEmail' => $userEmail,
        ]);
    }
}
