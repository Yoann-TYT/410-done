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
        return $this->json('[
    {
        "uuid": "c43de0f1-b270-4f21-99c6-67ff608ce6be",
        "name": "The winners",
        "users": [
            {
                "uuid": "59aa9168-7ee4-4867-8e07-531f17139a37",
                "name": "John Doe",
                "email": "john@doe.local",
                "city": "New York"
            },
            {
                "uuid": "fcde031c-6551-4f35-a17b-6e721e6c0e3e",
                "name": "Jane Doe",
                "email": "jane@doe.local",
                "city": "New York"
            }
        ]
    }
]');
        //return $this->json($this->dataProvider->getTeamsWithUsers());
    }
}
