<?php

namespace App\Controller;

use App\Service\SeanceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SeanceController extends AbstractController
{
    public function __construct(private readonly SeanceService $seanceService)
    {
    }

    #[Route('/seances/{id}', name: 'app_seance_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(int $id): Response
    {
        $detail = $this->seanceService->detail($id);
        if ($detail === null) {
            throw $this->createNotFoundException('Séance introuvable');
        }

        return $this->render('seance/show.html.twig', [
            'detail' => $detail,
        ]);
    }
}