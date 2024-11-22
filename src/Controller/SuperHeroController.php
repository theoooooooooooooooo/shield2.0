<?php

namespace App\Controller;

use App\Entity\Pouvoir;
use App\Entity\SuperHero;
use App\Form\SuperHeroType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SuperHeroController extends AbstractController
{
    #[Route('/SuperHero', name: 'app_SuperHero')]
    public function index(EntityManagerInterface $em): Response
    {
        $superHeros = $em->getRepository(SuperHero::class)->findAll();
        
        return $this->render('super_hero/index.html.twig', [
            'superHeros' => $superHeros,
        ]);
    }

    #[Route('/SuperHero/{id}', name: 'app_showDetail')]
    public function show(Request $request, EntityManagerInterface $em, int $id): Response
    {
        $superHero = $em->getRepository(SuperHero::class)->find($id);

        // Crée un formulaire modifiable
        $form = $this->createForm(SuperHeroType::class, $superHero);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide, enregistrer les modifications
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($superHero);
            $em->flush();

            $this->addFlash('success', 'Les informations du super-héros ont été mises à jour avec succès !');
            return $this->redirectToRoute('app_showDetail', ['id' => $id]);
        }

        return $this->render('super_hero/show.html.twig', [
            'form' => $form->createView(),
            'superHero' => $superHero,
        ]);
    }


    #[Route('/CreerSuperHero', name: 'app_CreerSuperHero')]
    public function creer(Request $request, EntityManagerInterface $em): Response
    {
        $superHero = new SuperHero();
        // Crée un formulaire modifiable
        $form = $this->createForm(SuperHeroType::class);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide, enregistrer les modifications
        if ($form->isSubmitted() && $form->isValid()) {
            $SuperHeroRecupForm = $form->getData();
            $em->persist($SuperHeroRecupForm);
            $em->flush();

            $this->addFlash('success', 'Les informations du super-héros ont été créer avec succès !');
            return $this->redirectToRoute('app_SuperHero');
        }

        return $this->render('super_hero/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/SuppSuperHero/{id}', name:'app_SuppSuperHero')]
    public function supp(EntityManagerInterface $em, int $id):Response
    {
        $superHero = $em->getRepository(SuperHero::class)->find($id);
        $em->remove($superHero);
        $em->flush();
        $this->addFlash('success', 'Le super-héros a été supprimé avec succès.');
        return $this->redirectToRoute('app_SuperHero');
    }
}
