<?php

namespace App\Controller\Catalogs\Listing;

use App\Repository\ListingRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ListingController extends AbstractController
{
    #[Route('/listing/{id}', name: 'listing', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function listing(int $id, ListingRepository $listingRepository, UserRepository $userRepository): Response
    {

        $listing = $listingRepository->find($id);

        if (!$listing) {
            throw $this->createNotFoundException('Listing not found');
        }

        // user 1 en fallback en attendant de le remplacer par vrai utilisateur connecté
        $user = $userRepository->find(1);
        $userId = $user ? $user->getId() : null;


        $isFavorited = false;
        if ($user) {
            $isFavorited = $user->getFavoriteListings()->contains($listing);
        }

        return $this->render('catalogs/listing/listing.html.twig', [
            'listing' => $listing,
            'userId' => $userId,
            'isFavorited' => $isFavorited,
        ]);
    }

    #[Route('/createlisting', name: 'createlisting')]
    public function createListing(): Response
    {
        return $this->render('catalogs/listing/create-listing.html.twig');
    }

    #[Route('/modifylisting', name: 'modifylisting')]
    public function modifyListing(): Response
    {
        return $this->render('catalogs/listing/modify-listing.html.twig');
    }
}
