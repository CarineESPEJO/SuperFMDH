<?php

namespace App\Controller\Catalogs\Listing;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ListingControllers extends AbstractController
{
    #[Route('/listing/{id}', name: 'listing', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function listing(int $id): Response
    {
        $listing = array_filter(\App\Controller\HomeController::LISTINGS, fn($l) => $l['id'] === $id);
        $listing = reset($listing);

        if (!$listing) {
            throw $this->createNotFoundException('Listing not found');
        }

        return $this->render('catalogs/listing/listing.html.twig', [
            'listing' => $listing,
        ]);
    }


    #[Route('/createlisting', name: 'createlisting')]
    public function createListing(): Response
    {
        return $this->render('catalogs/listing/create-listing.html.twig', []);
    }

    #[Route('/modifylisting', name: 'modifylisting')]
    public function modifyListing(): Response
    {
        return $this->render('catalogs/listing/modify-listing.html.twig', []);
    }
}
