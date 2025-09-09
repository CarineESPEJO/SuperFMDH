<?php

namespace App\Controller\Catalogs;

use App\Entity\PropertyType;
use App\Repository\ListingRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogController extends AbstractController
{
    private int $perPage = 12;

    private function paginate(array $items, Request $request): array
    {
        $currentPage = max((int)$request->query->get('page', 1), 1);
        $totalItems = count($items);
        $totalPages = (int)ceil($totalItems / $this->perPage);

        $paginatedItems = array_slice($items, ($currentPage - 1) * $this->perPage, $this->perPage);

        return [
            'listings' => $paginatedItems,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
        ];
    }

    #[Route('/apartments', name: 'apartments')]
    public function apartments(
        ListingRepository $listingRepository,
        UserRepository $userRepository,
        Request $request
    ): Response {

        $user = $this->getUser() ?? $userRepository->find(1);
        $userId = $user ? $user->getId() : null;


        $favorites = [];
        if ($user) {
            foreach ($user->getFavoriteListings() as $fav) {
                $favorites[] = $fav->getId();
            }
        }


        $propertyType = 2;
        $allListings = $listingRepository->findBy(['propertyType' => $propertyType], ['created_at' => 'DESC']);

        $pagination = $this->paginate($allListings, $request);

        return $this->render('catalogs/apartments.html.twig', [
            'listings' => $pagination['listings'],
            'favorites' => $favorites,
            'userId' => $userId,
            'currentPage' => $pagination['currentPage'],
            'totalPages' => $pagination['totalPages'],
        ]);
    }

    #[Route('/houses', name: 'houses')]
    public function houses(
        ListingRepository $listingRepository,
        UserRepository $userRepository,
        Request $request
    ): Response {
        $user = $this->getUser() ?? $userRepository->find(1);
        $userId = $user ? $user->getId() : null;

        $favorites = [];
        if ($user) {
            foreach ($user->getFavoriteListings() as $fav) {
                $favorites[] = $fav->getId();
            }
        }


        $allListings = $listingRepository->findBy(['propertyType' => 1], ['created_at' => 'DESC']);
        $pagination = $this->paginate($allListings, $request);

        return $this->render('catalogs/houses.html.twig', [
            'listings' => $pagination['listings'],
            'favorites' => $favorites,
            'userId' => $userId,
            'currentPage' => $pagination['currentPage'],
            'totalPages' => $pagination['totalPages'],
        ]);
    }

    #[Route('/favorites', name: 'favorites')]
    public function favorites(UserRepository $userRepository, Request $request): Response
    {
        $user = $this->getUser() ?? $userRepository->find(1);
        $userId = $user ? $user->getId() : null;

        $allListings = $user ? $user->getFavoriteListings()->toArray() : [];

        $pagination = $this->paginate($allListings, $request);

        return $this->render('catalogs/favorites.html.twig', [
            'listings' => $pagination['listings'],
            'favorites' => array_map(fn($l) => $l->getId(), $allListings),
            'userId' => $userId,
            'currentPage' => $pagination['currentPage'],
            'totalPages' => $pagination['totalPages'],
        ]);
    }

    #[Route('/search', name: 'search')]
    public function search(UserRepository $userRepository, Request $request): Response
    {
        $user = $this->getUser() ?? $userRepository->find(1);
        $userId = $user ? $user->getId() : null;

        $allListings = $user ? $user->getFavoriteListings()->toArray() : [];

        $pagination = $this->paginate($allListings, $request);

        return $this->render('catalogs/favorites.html.twig', [
            'listings' => $pagination['listings'],
            'favorites' => array_map(fn($l) => $l->getId(), $allListings),
            'userId' => $userId,
            'currentPage' => $pagination['currentPage'],
            'totalPages' => $pagination['totalPages'],
        ]);
    }
}
