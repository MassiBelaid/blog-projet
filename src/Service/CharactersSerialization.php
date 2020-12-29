<?php

namespace App\Service;

use App\Entity\Character;
use Doctrine\ORM\EntityManagerInterface;


class CharactersSerialization
{
    public function getSerializedCharacters(EntityManagerInterface $manager)
    {
        $characters = $manager->getRepository(Character::class)->findAll();

        $serializedCharacters = [];

        foreach($characters as $character){
            $serializedCharacters[] = [
                'id' => $character->getId(),
                'name' => $character->getName(),
                'image' => $character->getImage(),
                'status' => $character->getStatus(),
                'race' => $character->getRace(),
                'location' => $character->getLocation(),
                'fisrtSeen' => $character->getFisrtSeen()
            ];
        }

        return $serializedCharacters;
    }

}