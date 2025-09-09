<?php

namespace App\Data;

class Listings
{
    public const LISTINGS = [
        [
            'id' => 1,
            'title' => 'Charmant appartement T2',
            'description' => 'Bel appartement rénové avec goût, idéal pour un jeune couple ou étudiant. Proche du centre-ville et des transports.',
            'img' => '/images/listings/apartments/file_00000000000000.00000001.jpg',
            'transaction' => 'rent',
            'price' => 750,
            'property' => 'apartment',
            'city' => 'Lyon',
            'isFavorited' => true,
        ],
        [
            'id' => 2,
            'title' => 'Charmante maison',
            'description' => 'Bel appartement rénové avec goût, idéal pour un jeune couple ou étudiant. Proche du centre-ville et des transports.',
            'img' => '/images/listings/houses/file_00000000000000.00000002.jpg',
            'transaction' => 'rent',
            'price' => 750,
            'property' => 'house',
            'city' => 'Lyon',
            'isFavorited' => true,
        ],
        [
            'id' => 3,
            'title' => 'Maison familiale avec jardin',
            'description' => 'Grande maison de 120m² avec 4 chambres, garage double et jardin arboré. Quartier calme, proche des écoles.',
            'img' => '/images/listings/houses/file_00000000000000.00000003.jpg',
            'transaction' => 'sale',
            'price' => 325000,
            'property' => 'house',
            'city' => 'Grenoble',
            'isFavorited' => false,
        ],
        [
            'id' => 4,
            'title' => 'Maison meublée moderne',
            'description' => 'Studio de 25m² entièrement équipé, cuisine ouverte, salle de bain neuve. Internet inclus dans le loyer.',
            'img' => '/images/listings/houses/file_00000000000000.00000004.jpg',
            'transaction' => 'rent',
            'price' => 550,
            'property' => 'house',
            'city' => 'Chambéry',
            'isFavorited' => false,
        ],
        [
            'id' => 5,
            'title' => 'Apartement familiale avec jardin',
            'description' => 'Grande maison de 120m² avec 4 chambres, garage double et jardin arboré. Quartier calme, proche des écoles.',
            'img' => '/images/listings/apartments/file_00000000000000.00000005.jpg',
            'transaction' => 'sale',
            'price' => 325000,
            'property' => 'apartment',
            'city' => 'Grenoble',
            'isFavorited' => false,
        ],
        [
            'id' => 6,
            'title' => 'Studio meublé moderne',
            'description' => 'Studio de 25m² entièrement équipé, cuisine ouverte, salle de bain neuve. Internet inclus dans le loyer.',
            'img' => '/images/listings/apartments/file_00000000000000.00000006.jpg',
            'transaction' => 'rent',
            'price' => 550,
            'property' => 'apartment',
            'city' => 'Chambéry',
            'isFavorited' => true,
        ],

    ];
}
