<?php

namespace App\Controller\Catalogs;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class FavoritesController extends AbstractController{
    #[Route('/favorites', name: 'favorites')]
    public function index(): Response {
        return $this->render('catalogs/favorites.html.twig', []);
    }
}