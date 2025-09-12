<?php

namespace App\Controller\Catalogs\Listing;

use App\Repository\ListingRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Entity\Listing;
use App\Form\ListingType;

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

    #[Route('/listing/create', name: 'createlisting')]
    #[IsGranted('ROLE_AGENT')]
    public function createListing(
        Request $request,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository
    ): Response {
        $user = $this->getUser() ?? $userRepository->find(1);

        $listing = new Listing();
        $listing->setUser($user);

        $form = $this->createForm(ListingType::class, $listing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($listing);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('catalogs/listing/create-listing.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/listing/modify/{id}', name: 'modifylisting', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    #[IsGranted('ROLE_AGENT')]
    public function modifyListing(
        int $id,
        ListingRepository $listingRepository,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $listing = $listingRepository->find($id);
        if (!$listing) {
            throw $this->createNotFoundException('Listing not found');
        }

        $form = $this->createForm(ListingType::class, $listing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush(); // updated_at will be automatically updated
            return $this->redirectToRoute('listing', ['id' => $listing->getId()]);
        }

        return $this->render('catalogs/listing/modify-listing.html.twig', [
            'form' => $form->createView(),
            'listing' => $listing
        ]);
    }
}
