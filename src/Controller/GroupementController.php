<?php

namespace App\Controller;

use App\Dto\GroupementFiltreDto;
use App\Dto\GroupementFormDto;
use App\Form\GroupementFiltreType;
use App\Form\GroupementType;
use App\Service\GroupementService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Le controleur ne fait aucun traitement metier : il recupere le DTO,
 * l'envoie au service et transmet le resultat a la vue.
 */
final class GroupementController extends AbstractController
{
    public function __construct(private readonly GroupementService $groupementService)
    {
    }

    #[Route('/', name: 'app_accueil')]
    public function accueil(): Response
    {
        return $this->redirectToRoute('app_groupement_index');
    }

    /**
     * Filtre, pagine et affiche la liste (une seule action pour les trois).
     */
    #[Route('/groupements', name: 'app_groupement_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $filtre = new GroupementFiltreDto();
        $filtre->page = max(1, $request->query->getInt('page', 1));

        $form = $this->createForm(GroupementFiltreType::class, $filtre);
        $form->handleRequest($request);

        return $this->render('groupement/index.html.twig', [
            'resultat' => $this->groupementService->lister($filtre),
            'formFiltre' => $form,
        ]);
    }

    #[Route('/groupements/nouveau', name: 'app_groupement_nouveau', methods: ['GET', 'POST'])]
    public function nouveau(Request $request): Response
    {
        $dto = new GroupementFormDto();
        $form = $this->createForm(GroupementType::class, $dto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $id = $this->groupementService->creer($dto);
            $this->addFlash('succes', 'Le groupement a été créé.');

            return $this->redirectToRoute('app_groupement_show', ['id' => $id]);
        }

        return $this->render('groupement/form.html.twig', [
            'form' => $form,
            'titre' => 'Nouveau groupement',
        ]);
    }

    #[Route('/groupements/{id}/modifier', name: 'app_groupement_modifier', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function modifier(int $id, Request $request): Response
    {
        $dto = $this->groupementService->formulaire($id);
        if ($dto === null) {
            throw $this->createNotFoundException('Groupement introuvable');
        }

        $form = $this->createForm(GroupementType::class, $dto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->groupementService->modifier($id, $dto);
            $this->addFlash('succes', 'Le groupement a été modifié.');

            return $this->redirectToRoute('app_groupement_show', ['id' => $id]);
        }

        return $this->render('groupement/form.html.twig', [
            'form' => $form,
            'titre' => 'Modifier le groupement',
        ]);
    }

    #[Route('/groupements/{id}', name: 'app_groupement_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(int $id): Response
    {
        $detail = $this->groupementService->detail($id);
        if ($detail === null) {
            throw $this->createNotFoundException('Groupement introuvable');
        }

        return $this->render('groupement/show.html.twig', [
            'detail' => $detail,
        ]);
    }
}