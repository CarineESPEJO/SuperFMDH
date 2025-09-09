<?php

namespace App\Controller;

use App\Repository\ListingRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ListingRepository $listingRepository, UserRepository $userRepository): Response
    {

        $houses = $listingRepository->findBy(['propertyType' => 1], ['created_at' => 'DESC'], 3);
        $apartments = $listingRepository->findBy(['propertyType' => 2], ['created_at' => 'DESC'], 3);


        $user = $userRepository->find(1);
        $userId = $user ? $user->getId() : null;


        $favorites = [];
        if ($user) {
            foreach ($user->getFavoriteListings() as $fav) {
                $favorites[] = $fav->getId();
            }
        }

        return $this->render('index.html.twig', [
            'houses' => $houses,
            'apartments' => $apartments,
            'favorites' => $favorites,
            'userId' => $userId,
        ]);
    }
}
