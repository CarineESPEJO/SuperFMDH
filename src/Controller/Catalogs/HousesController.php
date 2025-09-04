<?php

namespace App\Controller\Catalogs;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class HousesController extends AbstractController{
    #[Route('/houses', name: 'houses')]
    public function houses(): Response {
        return $this->render('catalogs/houses.html.twig', []);
    }
}