<?php

namespace App\Controller\Catalogs;

use App\Entity\User;
use App\Repository\ListingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/catalogs')]
class CatalogController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    public function getUser(): ?User
    {
        return parent::getUser();
    }

    #[Route('/favorites/toggle/{id}', name: 'toggle_favorite', methods: ['POST'])]
    public function toggleFavorite($id, ListingRepository $listingRepository): JsonResponse
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['status' => 'error', 'message' => 'User not logged in'], 403);
        }

        $listing = $listingRepository->find($id);
        if (!$listing) {
            return $this->json(['status' => 'error', 'message' => 'Listing not found'], 404);
        }

        if ($user->getFavoriteListings()->contains($listing)) {
            $user->removeFavoriteListing($listing);
            $this->entityManager->flush();
            return $this->json(['status' => 'removed']);
        }

        $user->addFavoriteListing($listing);
        $this->entityManager->flush();
        return $this->json(['status' => 'added']);
    }

    #[Route('/all', name: 'allListings')]
    public function allListings(ListingRepository $listingRepository, Request $request): Response
    {
        return $this->renderListingPage($listingRepository, $request);
    }

    #[Route('/houses', name: 'houses')]
    public function houses(ListingRepository $listingRepository, Request $request): Response
    {
        return $this->renderListingPage($listingRepository, $request, 'House');
    }

    #[Route('/apartments', name: 'apartments')]
    public function apartments(ListingRepository $listingRepository, Request $request): Response
    {
        return $this->renderListingPage($listingRepository, $request, 'Apartment');
    }

    #[Route('/favorites', name: 'favorites')]
    public function favorites(ListingRepository $listingRepository, Request $request): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $userId = $user->getId();
        $favoriteIds = $user->getFavoriteListings()
            ->map(fn($listing) => $listing->getId())
            ->toArray();

        $currentPage = max(1, (int) $request->query->get('page', 1));
        $limit = 6;

        $qb = $listingRepository->createQueryBuilder('l')
            ->where('l.id IN (:ids)')
            ->setParameter('ids', $favoriteIds ?: [0])
            ->orderBy('l.created_at', 'DESC');

        $totalListings = count($qb->getQuery()->getResult());
        $totalPages = (int) ceil($totalListings / $limit);

        $listings = $qb->setFirstResult(($currentPage - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        return $this->render('catalogs/favorites.html.twig', [
            'listings' => $listings,
            'favoriteIds' => $favoriteIds,
            'userId' => $userId,
            'isLoggedIn' => (bool) $user,
            'userEmail' => $user->getEmail(),
            'userRole' => $user->getRoles()[0] ?? null,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
        ]);
    }

    private function renderListingPage(ListingRepository $listingRepository, Request $request, ?string $propertyType = null): Response
    {
        $query = $request->query->get('q', '');
        $currentPage = max(1, (int) $request->query->get('page', 1));
        $limit = 6;

        $qb = $listingRepository->createQueryBuilder('l');

        if ($propertyType) {
            $qb->join('l.propertyType', 'pt')
                ->where('pt.name = :type')
                ->setParameter('type', $propertyType);
        }

        if ($query) {
            $qb->andWhere('l.title LIKE :query OR l.description LIKE :query')
                ->setParameter('query', "%$query%");
        }

        $qb->orderBy('l.created_at', 'DESC');

        $totalListings = count($qb->getQuery()->getResult());
        $totalPages = (int) ceil($totalListings / $limit);

        $listings = $qb->setFirstResult(($currentPage - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        $user = $this->getUser();
        $userId = null;
        $favoriteIds = [];

        if ($user) {
            $userId = $user->getId();
            $favoriteIds = $user->getFavoriteListings()
                ->map(fn($listing) => $listing->getId())
                ->toArray();
        }

        return $this->render('catalogs/all-listings.html.twig', [
            'listings' => $listings,
            'favoriteIds' => $favoriteIds,
            'userId' => $userId,
            'isLoggedIn' => (bool) $user,
            'userEmail' => $user?->getEmail(),
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'query' => $query,
        ]);
    }
}
