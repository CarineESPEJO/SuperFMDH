<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ListingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ListingRepository $listingRepository): Response
    {
        $houses = $listingRepository->findBy(['propertyType' => 1], ['created_at' => 'DESC'], 3);
        $apartments = $listingRepository->findBy(['propertyType' => 2], ['created_at' => 'DESC'], 3);

        /** @var User|null $user */
        $user = $this->getUser();

        $userId = null;
        $favoriteIds = [];

        if ($user) {
            $userId = $user->getId();
            $favoriteIds = $user->getFavoriteListings()
                ->map(fn($l) => $l->getId())
                ->toArray();
        }

        return $this->render('index.html.twig', [
            'houses' => $houses,
            'apartments' => $apartments,
            'favoriteIds' => $favoriteIds,
            'userId' => $userId,
            'isLoggedIn' => (bool) $user,
            'userEmail' => $user?->getEmail(),
        ]);
    }
}
