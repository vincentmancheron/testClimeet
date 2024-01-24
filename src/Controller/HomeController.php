<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController
{
    #[Route('/', 'index', methods: ['GET'])]
    public function index(): Response
    {

        return new Response(
            `<html>
                <body>
                    <h2>Bienvenue sur l'Api testClimeet</h2>
                    <p>Munissez-vous d'un token pour exploitation (/login_check)</p>
                </body>
            </html>`
        );
    }

    #[Route('/checkBearer', 'app_checkBearer', methods: ['GET'])]
    public function checkBearer(): JsonResponse
    {
        return new JsonResponse('authenticated', Response::HTTP_OK, [], true);
    }
}