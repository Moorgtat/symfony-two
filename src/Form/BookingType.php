<?php

namespace App\Form;

use App\Entity\Booking;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookingType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', DateType::class, 
            $this->getConfiguration("Date d'arrivée",
            "La date de votre arrivée...", ["widget" => "single_text"]))
            ->add('endDate', DateType::class, 
            $this->getConfiguration("Date de départ",
            "La date de votre départ...", ["widget" => "single_text"]))
            ->add('comment', TextareaType::class,
            $this->getConfiguration( false,
            "Si vous avez un commentaire, partagez le ici...", ["required" => false]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
