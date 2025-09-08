<?php

namespace App\Controller\Catalogs;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class CatalogController extends AbstractController
{
    #[Route('/apartments', name: 'apartments')]
    public function apartments(): Response
    {
        return $this->render('catalogs/apartments.html.twig', []);
    }

    #[Route('/houses', name: 'houses')]
    public function houses(): Response
    {
        return $this->render('catalogs/houses.html.twig', []);
    }

    #[Route('/favorites', name: 'favorites')]
    public function favorites(): Response
    {
        return $this->render('catalogs/favorites.html.twig', []);
    }
    #[Route('/search', name: 'search')]
    public function search(): Response
    {
        return $this->render('catalogs/search.html.twig', []);
    }
}
