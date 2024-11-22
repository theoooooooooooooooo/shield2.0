<?php

namespace App\Controller;

use App\Entity\Pouvoir;
use App\Form\PouvoirType;
use App\Repository\PouvoirRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PouvoirController extends AbstractController{
    #[Route('/Pouvoir', name: 'app_Pouvoir')]
    public function index(PouvoirRepository $pouvoirRepository): Response
    {
        return $this->render('pouvoir/index.html.twig', [
            'pouvoirs' => $pouvoirRepository->findAll(),
        ]);
    }

    #[Route('/CreerPouvoir', name: 'app_pouvoir_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pouvoir = new Pouvoir();
        $form = $this->createForm(PouvoirType::class, $pouvoir);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($pouvoir);
            $entityManager->flush();

            return $this->redirectToRoute('app_Pouvoir', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pouvoir/new.html.twig', [
            'pouvoir' => $pouvoir,
            'form' => $form,
        ]);
    }

    #[Route('/Pouvoir/{id}', name: 'app_pouvoir_show')]
    public function showPouvoir(EntityManagerInterface $em, Request $request, int $id): Response
    {
        // Récupérer le pouvoir
        $pouvoir = $em->getRepository(Pouvoir::class)->find($id);
    
        $form = $this->createForm(PouvoirType::class, $pouvoir);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Les informations du pouvoir ont été mises à jour.');
            return $this->redirectToRoute('app_Pouvoir');
        }
    
        // Rendre la vue
        return $this->render('pouvoir/show.html.twig', [
            'pouvoir' => $pouvoir,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/SuppPouvoir/{id}', name:'app_SuppPouvoir')]
    public function supp(EntityManagerInterface $em, int $id):Response
    {
        $pouvoir = $em->getRepository(Pouvoir::class)->find($id);
        foreach ($pouvoir->getSuperHeroes() as $hero) {
            $hero->removePouvoir($pouvoir);
        }

        $em->remove($pouvoir);
        $em->flush();

        $this->addFlash('success', 'Le pouvoir a été supprimé avec succès.');
        return $this->redirectToRoute('app_Pouvoir');
    }
}
