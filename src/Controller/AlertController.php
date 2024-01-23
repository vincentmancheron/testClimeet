<?php

namespace App\Controller;

use App\Entity\Alert;
use App\Repository\AlertRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class AlertController extends AbstractController
{
    #[Route('/alerts', name: 'app_alert_create', methods: ['POST'])]
    public function createOne(Request $request, EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse
    {
        $alert = $serializer->deserialize($request->getContent(), Alert::class, 'json');
        $em->persist($alert);
        $em->flush();
        $jsonAlert = $serializer->serialize($alert, 'json', []);
        return new JsonResponse($jsonAlert, Response::HTTP_CREATED, [], true);
    }

    #[Route('/alerts/{id}', name: 'app_alert_update', methods: ['PUT'])]
    public function updateOne(int $id, Request $request, EntityManagerInterface $em, AlertRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $currentAlert = $repository->find($id);
        $updatedAlert = $serializer->deserialize($request->getContent(), Alert::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $currentAlert]);
        $updatedAlert->setUpdatedAt(new \DateTimeImmutable());
        $em->persist($updatedAlert);
        $em->flush();
        $jsonAlert = $serializer->serialize($updatedAlert, 'json', []);
        return new JsonResponse($jsonAlert, Response::HTTP_CREATED, [], true);
    }

    #[Route('/alerts', name: 'app_alerts', methods: ['GET'])]
    public function findAll(AlertRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $alerts = $repository->findAll();
        $jsonAlerts = $serializer->serialize($alerts, 'json');

        return new JsonResponse($jsonAlerts, Response::HTTP_OK, [], true);
    }

    #[Route('/alerts/{id}', name: 'app_alert', methods: ['GET'])]
    public function findOne(int $id, AlertRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $alert = $repository->find($id);
        if ($alert) {
            $jsonAlert = $serializer->serialize($alert, 'json');
            return new JsonResponse($jsonAlert, Response::HTTP_OK, [], true);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    #[Route('/alerts/{id}', name: 'app_alert_delete', methods: ['DELETE'])]
    public function deleteOne(int $id, AlertRepository $repository, EntityManagerInterface $em): JsonResponse
    {
        $alert = $repository->find($id);
        if ($alert) {
            $alert->setDeletedAt(new \DateTimeImmutable());
            $em->persist($alert);
            $em->flush();
            return new JsonResponse('Alerte supprimé', Response::HTTP_OK, []);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}
