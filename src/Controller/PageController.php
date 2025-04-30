<?php

namespace App\Controller;

use App\Entity\Page;
use App\Form\PageType;
use App\Repository\PageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/page')]
final class PageController extends AbstractController
{
    #[Route(name: 'app_page_index', methods: ['GET'])]
    public function index(PageRepository $pageRepository, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $pages = $pageRepository->findAll();
        foreach($pages as $page){
            if($page->getUrl() != null){
                $page->setSlug($page->getUrl(), $slugger);
                $entityManager->flush();
            }
        }
        return $this->render('page/index.html.twig', [
            'pages' => $pages,
        ]);
    }

    #[Route('/new', name: 'app_page_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $page = new Page();
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $security->getUser();
            $page->setUser($user);

            $entityManager->persist($page);
            $entityManager->flush();

            return $this->redirectToRoute('app_page_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('page/new.html.twig', [
            'page' => $page,
            'form' => $form,
        ]);
    }

    #[Route('/{url}', name: 'app_page_show', methods: ['GET'])]
    public function show(PageRepository $pageRepository, string $url): Response
    {
        if(is_numeric($url)){
            $page = $pageRepository->find((int)$url);
        }else{
            $page = $pageRepository->findOneByUrl($url);
        }

        if ($page->getGalerie() !== null) {
            $galerie = $page->getGalerie();
        } else {
            $galerie = null;
        }

        return $this->render('page/template.html.twig', [
            'page' => $page,
            'galerie' => $galerie,
        ]);
    }

    #[Route('/{url}/edit', name: 'app_page_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, string $url, EntityManagerInterface $entityManager, PageRepository $pageRepository): Response
    {
        if(is_numeric($url)){
            $page = $pageRepository->find((int)$url);
        }else{
            $page = $pageRepository->findOneByUrl($url);
        }

        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_page_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('page/edit.html.twig', [
            'page' => $page,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_page_delete', methods: ['POST'])]
    public function delete(Request $request, Page $page, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$page->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($page);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_page_index', [], Response::HTTP_SEE_OTHER);
    }
}
