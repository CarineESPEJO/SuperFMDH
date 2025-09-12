<?php

namespace App\Controller\Catalogs\Listing;

use App\Repository\ListingRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Entity\Listing;
use App\Form\ListingType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ListingController extends AbstractController
{
    #[Route('/listing/{id}', name: 'listing', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function listing(int $id, ListingRepository $listingRepository, UserRepository $userRepository): Response
    {
        $listing = $listingRepository->find($id);
        if (!$listing) {
            throw $this->createNotFoundException('Listing not found');
        }

        // Temporary fallback user, replace with actual logged-in user
        $user = $this->getUser() ?? $userRepository->find(1);
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
        UserRepository $userRepository,
        SluggerInterface $slugger
    ): Response {
        $user = $this->getUser() ?? $userRepository->find(1);
        $listing = new Listing();
        $listing->setUser($user);

        $form = $this->createForm(ListingType::class, $listing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image_file')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $extension = $imageFile->guessExtension();
                $newFilename = 'file_' . uniqid('', true) . '.' . $extension;

                $propertyTypeFolder = strtolower($listing->getPropertyType()->getName()); // houses or apartments
                $targetDirectory = $this->getParameter('listings_directory') . '/' . $propertyTypeFolder;

                try {
                    $imageFile->move($targetDirectory, $newFilename);
                    $listing->setImageUrl('images/listings/' . $propertyTypeFolder . '/' . $newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Failed to upload image.');
                }
            }

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
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    ): Response {
        $listing = $listingRepository->find($id);
        if (!$listing) {
            throw $this->createNotFoundException('Listing not found');
        }

        $form = $this->createForm(ListingType::class, $listing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image_file')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $extension = $imageFile->guessExtension();
                $newFilename = 'file_' . uniqid('', true) . '.' . $extension;

                $propertyTypeFolder = strtolower($listing->getPropertyType()->getName()); // houses or apartments
                $targetDirectory = $this->getParameter('listings_directory') . '/' . $propertyTypeFolder;

                try {
                    $imageFile->move($targetDirectory, $newFilename);
                    $listing->setImageUrl('images/listings/' . $propertyTypeFolder . '/' . $newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Failed to upload image.');
                }
            }

            $entityManager->flush(); // updated_at handled by TimestampableTrait

            return $this->redirectToRoute('listing', ['id' => $listing->getId()]);
        }

        return $this->render('catalogs/listing/modify-listing.html.twig', [
            'form' => $form->createView(),
            'listing' => $listing,
        ]);
    }
}
