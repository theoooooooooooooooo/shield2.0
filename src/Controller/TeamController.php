<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TeamController extends AbstractController
{
    #[Route('/Team', name: 'app_Team')]
    public function index(EntityManagerInterface $em): Response
    {
        $teams = $em->getRepository(Team::class)->findAll();
        return $this->render('team/index.html.twig', [
            'teams' => $teams,
        ]);
    }
    #[Route('/Team/{id}', name: 'app_ShowTeam')]
    public function show(Request $request, EntityManagerInterface $em, int $id): Response
    {
        $team = $em->getRepository(Team::class)->find($id);
        // Crée un formulaire modifiable
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide, enregistrer les modifications
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($team);
            $em->flush();

            $this->addFlash('success', 'Les informations du super-héros ont été créer avec succès !');
            return $this->redirectToRoute('app_Team');
        }

        return $this->render('team/show.html.twig', [
            'team' => $team,
            'form' => $form,
        ]);
    }


    #[Route('/CreerTeam', name: 'app_CreerTeam')]
    // public function creer(Request $request, EntityManagerInterface $em): Response
    // {
    //     $team = new Team();
    //     // Crée un formulaire modifiable
    //     $form = $this->createForm(TeamType::class);
    //     $form->handleRequest($request);

    //     // Si le formulaire est soumis et valide, enregistrer les modifications
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $teamRecupForm = $form->getData();
    //         $em->persist($teamRecupForm);
    //         $em->flush();

    //         $this->addFlash('success', 'Les informations du super-héros ont été créer avec succès !');
    //         return $this->redirectToRoute('app_Team');
    //     }

    //     return $this->render('team/create.html.twig', [
    //         'form' => $form,
    //     ]);
    // }

    public function creer(Request $request, EntityManagerInterface $em): Response
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->persist($team);
                $em->flush();
                $this->addFlash('success', 'Équipe créée avec succès !');
                return $this->redirectToRoute('app_CreerTeam');
            } catch (\LogicException $e) {
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('team/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/SuppTeam/{id}', name:'app_SuppTeam')]
    public function supp(EntityManagerInterface $em, int $id):Response
    {
        $team = $em->getRepository(Team::class)->find($id);
        foreach ($team->getMembers() as $members) {
            $members->removeTeam($team);
        }

        $em->remove($team);
        $em->flush();

        $this->addFlash('success', 'La team a été supprimé avec succès.');
        return $this->redirectToRoute('app_Team');
    }
}
