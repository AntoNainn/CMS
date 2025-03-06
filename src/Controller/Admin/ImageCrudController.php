<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Repository\GalerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class ImageCrudController extends AbstractCrudController
{
    private Security $security;
    private GalerieRepository $galerieRepository;

    public function __construct(Security $security, GalerieRepository $galerieRepository)
    {
        $this->security = $security;
        $this->galerieRepository = $galerieRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Image::class;
    }

    public function configureFields(string $pageName): iterable
    {
        // ✅ Récupérer l'utilisateur connecté
        $user = $this->security->getUser();
        $galeries = $this->galerieRepository->findByUserLogin($user);

        // ✅ Transformer les résultats en tableau pour `ChoiceField`
        $choices = [];
        foreach ($galeries as $galerie) {
            $choices[$galerie->getNom()] = $galerie->getId(); // 'label' => 'valeur'
        }

        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('legende', 'Légende'),
            Field::new('imageFile')->setFormType(FileType::class)->setLabel('Import Image')->onlyOnForms(),
            AssociationField::new('galerie')->setLabel('Galerie')->autocomplete(),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        /** @var Image $entityInstance */
        $imageFile = $entityInstance->getImageFile();

        if ($imageFile instanceof UploadedFile) {
            $imageData = file_get_contents($imageFile->getRealPath());
            $base64Image = base64_encode($imageData);
            $entityInstance->setPath($base64Image);
        }

        parent::persistEntity($entityManager, $entityInstance);
    }
}
