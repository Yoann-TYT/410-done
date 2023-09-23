<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return (new Response(
            file_get_contents(__ROOT_DIR__ . '/templates/index.html'),
            Response::HTTP_OK,
            ['Content-Type' => 'text/html']
        ))->setSharedMaxAge(3600);
    }
}
