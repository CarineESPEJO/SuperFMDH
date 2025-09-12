<?php

namespace App\Controller;

use App\Entity\Listing;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class FavoriteController extends AbstractController
{
    #[Route('/favorites/toggle/{id}', name: 'favorite_toggle', methods: ['POST'])]
    #[IsGranted('ROLE_USER')] // Only admins can toggle
    public function toggle(Listing $listing, EntityManagerInterface $em): JsonResponse
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        if ($user->getFavoriteListings()->contains($listing)) {
            $user->removeFavoriteListing($listing);
            $status = 'removed';
        } else {
            $user->addFavoriteListing($listing);
            $status = 'added';
        }

        $em->persist($user);
        $em->flush();

        return new JsonResponse(['status' => $status]);
    }
}
