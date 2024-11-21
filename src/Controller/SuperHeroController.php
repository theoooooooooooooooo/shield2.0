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

        if (!$superHero) {
            throw $this->createNotFoundException('Super héros non trouvé.');
        }

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


    // #[Route('/CreerSuperHero', name: 'app_SuperHero')]
    // public function creer(EntityManagerInterface $em): Response
    // {
    //     $superHero = new SuperHero();
    //     $form = "test";
        
    //     return $this->render('super_hero/index.html.twig', [
    //         'form' => $form,
    //     ]);
    // }
}
