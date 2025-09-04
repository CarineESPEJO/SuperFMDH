<?php

namespace App\Controller\Catalogs\Listing;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ListingControllers extends AbstractController{
#[Route('/listing', name: 'listing')]
    public function listing(): Response {
        return $this->render('catalogs/listing/listing.html.twig', []);
    }

    #[Route('/createlisting', name: 'createlisting')]
    public function createListing(): Response {
        return $this->render('catalogs/listing/createListing.html.twig', []);
    }

    #[Route('/modifylisting', name: 'modifylisting')]
    public function modifyListing(): Response {
        return $this->render('catalogs/listing/modifyListing.html.twig', []);
    }
}