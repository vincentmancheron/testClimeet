<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController
{
    #[Route('/', 'index', methods: ['GET'])]
    public function index(): Response
    {

        return new Response(
            "<html><body>Bienvenue sur l'Api testClimeet</body></html>"
        );
    }
}