<?php

namespace App\Form;

use App\Entity\Product;
use App\Form\ImageType;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProductType extends ApplicationType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 
                TextType::class, 
                $this->getConfiguration("Titre", "Le titre de votre annonce"))
            ->add('slug', 
                TextType::class, 
                $this->getConfiguration("Adresse Web", "Adresse web de votre annonce",
                [ 'required' => false ]))
            ->add('introduction', 
                TextType::class, 
                $this->getConfiguration("Introduction","Donnez une description global de votre annonce"))
            ->add('content', 
                TextareaType::class, 
                $this->getConfiguration("Description détaillé", "Description détaillé de votre annonce"))
            ->add('coverImage', 
                UrlType::class, 
                $this->getConfiguration("Url image principal", "L'image principale de votre annonce"))
            ->add('rooms', 
                IntegerType::class, 
                $this->getConfiguration("Nombre de chambres", "Nombre de chambres disponibles"))
            ->add('price', 
                MoneyType::class, 
                $this->getConfiguration("Prix par nuit", "Le prix par nuit"))
            ->add('images',
                CollectionType::class,
                [
                    'entry_type' => ImageType::class,
                    'allow_add' => true,
                    'allow_delete' => true
                ]
            )
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
