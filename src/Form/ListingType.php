<?php

namespace App\Form;

use App\Entity\Listing;
use App\Entity\PropertyType;
use App\Entity\TransactionType;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ListingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('price', NumberType::class, [
                'scale' => 2,
                'html5' => true,      // generates <input type="number" step="0.01">
            ])
            ->add('city')
            ->add('image_url')
            ->add('propertyType', EntityType::class, [
                'class' => PropertyType::class,
                'choice_label' => 'name',
            ])
            ->add('transactionType', EntityType::class, [
                'class' => TransactionType::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Listing::class,
        ]);
    }
}
