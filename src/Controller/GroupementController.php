<?php

namespace App\Controller;

use App\Service\GroupementService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Le controleur ne fait aucun traitement metier : il appelle le service
 * et transmet les DTO a la vue.
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

    #[Route('/groupements', name: 'app_groupement_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('groupement/index.html.twig', [
            'groupements' => $this->groupementService->lister(),
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