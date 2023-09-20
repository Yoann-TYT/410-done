<?php

namespace App\Controller;

use App\Provider\DataProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/teams', name: 'app_teams_')]
class TeamController extends AbstractController
{
    public function __construct(private DataProvider $dataProvider)
    {
    }
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json($this->dataProvider->getTeamsWithUsers());
    }
}
