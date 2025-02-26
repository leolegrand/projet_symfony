<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\HttpFoundation\Request;
class AuthentificationController extends CustomAbstractController
{
    public function __construct(protected SerializerInterface $serializer, private EntityManagerInterface $em)
    {
        parent::__construct($serializer);
    }

    #[Route('api/users/register', methods: ['POST'])]
    // #[IsGranted('ROLE_ADMIN')]
    public function register(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        if(!isset($data['email'], $date['password'])) {
            return new JsonResponse(['message'=> 'Wrong arguments'], 400);
        }

        $user = new User();
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);
        // $user->setRole( 'ROLE_ADMIN');

        $this->em->persist($user);
        $this->em->flush();

        return new JsonResponse(['message'=> 'User created'], 201);
    }
}