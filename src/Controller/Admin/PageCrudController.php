<?php

namespace App\Controller\Admin;

use App\Entity\Page;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;


class PageCrudController extends AbstractCrudController
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getEntityFqcn(): string
    {
        return Page::class;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Page) {
            return;
        }

        // Assigner l'utilisateur connecté
        $user = $this->security->getUser();
        if ($user) {
            $entityInstance->setUser($user);
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre'),
            TextEditorField::new('contenu')
                ->setFormTypeOptions([
                    'attr' => ['id' => 'contenu']
                ]),
            TextField::new('meta'),
            TextField::new('url'),
        ];
    }
}
