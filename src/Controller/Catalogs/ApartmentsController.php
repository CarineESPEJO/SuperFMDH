<?php

namespace App\Controller\Catalogs;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ApartmentsController extends AbstractController{
    #[Route('/apartments', name: 'apartments')]
    public function index(): Response {
        return $this->render('catalogs/apartments.html.twig', []);
    }
}