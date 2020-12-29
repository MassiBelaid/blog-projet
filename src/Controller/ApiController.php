<?php

namespace App\Controller;

use App\Service\CharactersSerialization;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/characters", name="characters", methods={"GET"})
     */
    public function index(EntityManagerInterface $manager, CharactersSerialization $service): Response
    {
        $serializedCharacters = $service->getSerializedCharacters($manager);

        return new JsonResponse(['data' => $serializedCharacters, 'items' => count($serializedCharacters)]);
    }
}
