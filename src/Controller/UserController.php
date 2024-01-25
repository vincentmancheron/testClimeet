<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/users', name: 'app_user_create', methods: ['POST'])]
    public function createOne(Request $request, EntityManagerInterface $em, SerializerInterface $serializer, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $user = $serializer->deserialize($request->getContent(), User::class, 'json');
        // ! Bug sur le hashage.
        // $user->setPassword($user->userPasswordHasher->hashPassword($user, $user->getPassword()));
        $em->persist($user);
        $em->flush();
        $jsonUser = $serializer->serialize($user, 'json');
        return new JsonResponse($jsonUser, Response::HTTP_CREATED, [], true);
    }

    #[Route('/users/{id}', name: 'app_user_update', methods: ['PUT'])]
    public function updateOne(int $id, Request $request, EntityManagerInterface $em, UserRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $currentUser = $repository->find($id);
        $updatedUser = $serializer->deserialize($request->getContent(), User::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $currentUser]);
        $updatedUser->setUpdatedAt(new \DateTimeImmutable());
        $em->persist($updatedUser);
        $em->flush();
        $jsonUser = $serializer->serialize($updatedUser, 'json', []);
        return new JsonResponse($jsonUser, Response::HTTP_CREATED, [], true);
    }

    #[Route('/users', name: 'app_users', methods: ['GET'])]
    public function findAll(UserRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $users = $repository->findBy(
            ['deletedAt' => null]
        );
        $jsonUsers = $serializer->serialize($users, 'json', ['groups' => 'getUsers']);

        return new JsonResponse($jsonUsers, Response::HTTP_OK, [], true);
    }

    #[Route('/users/{id}', name: 'app_user', methods: ['GET'])]
    public function findOne(int $id, UserRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $user = $repository->find($id);
        if ($user) {
            $jsonUser = $serializer->serialize($user, 'json');
            return new JsonResponse($jsonUser, Response::HTTP_OK, [], true);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    #[Route('/users/{id}', name: 'app_user_delete', methods: ['DELETE'])]
    public function deleteOne(int $id, UserRepository $repository, EntityManagerInterface $em): JsonResponse
    {
        $user = $repository->find($id);
        if ($user) {
            $user->setDeletedAt(new \DateTimeImmutable());
            $em->persist($user);
            $em->flush();
            return new JsonResponse('Utilisateur supprimé', Response::HTTP_OK, []);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}
