<?php

namespace App\Form;

use App\Entity\Galerie;
use App\Entity\Image;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('legende')
            ->add('imageFile', FileType::class, [
                'label' => 'Import Image',
                'required' => false, // facultatif selon ton besoin
                'mapped' => false, // important si l’image n’est pas directement stockée dans la propriété
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Veuillez importer une image valide (JPEG, PNG, WEBP)',
                    ])
                ],
            ])
            ->add('galerie', EntityType::class, [
                'class' => Galerie::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
