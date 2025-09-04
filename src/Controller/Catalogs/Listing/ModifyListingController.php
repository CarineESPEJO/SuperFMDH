<?php

namespace App\Controller\Catalogs\Listing;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ModifyListingController extends AbstractController{
    #[Route('/modifylisting', name: 'modifylisting')]
    public function modifyListing(): Response {
        return $this->render('catalogs/listing/modifyListing.html.twig', []);
    }
}