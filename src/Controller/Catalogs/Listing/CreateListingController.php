<?php

namespace App\Controller\Catalogs\Listing;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class CreateListingController extends AbstractController{
    #[Route('/createlisting', name: 'createlisting')]
    public function index(): Response {
        return $this->render('catalogs/listing/createListing.html.twig', []);
    }
}