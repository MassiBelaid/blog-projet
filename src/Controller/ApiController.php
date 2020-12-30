<?php

namespace App\Controller;

use App\Entity\Character;
use Doctrine\DBAL\Schema\View;
use App\Repository\CharacterRepository;
use App\Service\CharactersSerialization;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
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


    /**
     * @Route("/api/characters/{id}", name="single_characters", methods={"GET"})
     */
    public function indexWithId($id, CharacterRepository $characterRepository): JsonResponse
    {
        $character = $characterRepository->findOneBy(['id' => $id]);

        if($character){
        
            $data = [
                'id' => $character->getId(),
                'name' => $character->getName(),
                'image' => $character->getImage(),
                'status' => $character->getStatus(),
                'race' => $character->getRace(),
                'location' => $character->getLocation(),
                'firstSeen' => $character->getFisrtSeen()
            ];

            return new JsonResponse($data, Response::HTTP_OK);
        } else {
            return new JsonResponse(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }   

}
