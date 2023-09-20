<?php

namespace App\Controller;

use App\Provider\DataProvider;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

#[Route('/teams', name: 'app_teams_')]
class TeamController extends AbstractController
{
    public function __construct(private DataProvider $dataProvider, private CacheInterface $cacheManager)
    {
    }
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $teams = $this->cacheManager->get('teams', function (ItemInterface $item) {
            $item->expiresAfter(3600);

            return $this->dataProvider->getTeamsWithUsers();
        });

        return $this->json($teams);
    }
    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $this->cacheManager->delete('teams');
    }
}
