<?php

namespace App\Controller\Catalogs\Listing;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ListingController extends AbstractController{
    #[Route('/listing', name: 'listing')]
    public function index(): Response {
        return $this->render('catalogs/listing/listing.html.twig', []);
    }
}