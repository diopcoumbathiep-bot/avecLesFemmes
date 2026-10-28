<?php

namespace App\Controller;

use App\Service\CampagneService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CampagneController extends AbstractController
{
    public function __construct(private readonly CampagneService $campagneService)
    {
    }

    #[Route('/campagnes/{id}', name: 'app_campagne_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(int $id): Response
    {
        $detail = $this->campagneService->detail($id);
        if ($detail === null) {
            throw $this->createNotFoundException('Campagne introuvable');
        }

        return $this->render('campagne/show.html.twig', [
            'detail' => $detail,
        ]);
    }
}