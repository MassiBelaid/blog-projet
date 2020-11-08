<?php

namespace App\Service;

use App\Entity\Character;
use function Symfony\Component\String\u;
use Symfony\Component\HttpClient\HttpClient;


class GetFromApiService
{
    private $httpClient;

    public function getCharacters() 
    {
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://rickandmortyapi.com/api/character/');

        $statusCode = $response->getStatusCode();

        $characters = Array();

        if (200 !== $statusCode) {
            $retour = "erreur ".$statusCode;
        } else {
            $content = $response->getContent();
            $content = $response->toArray();

            $results = $content['results'];

            for($i = 0; $i < sizeof($results); $i++)
            {
                $character = new Character();
                $characterString = $results[$i];

                $firstSeen = 'episode '.u($characterString['episode'][0])->afterLast('/');

                $character->setName($characterString['name'])
                            ->setStatus($characterString['status'])
                            ->setRace($characterString['species'])
                            ->setLocation($characterString['origin']['name'])
                            ->setFisrtSeen($firstSeen);

                array_push($characters, $character);
            }

        }
        return $characters;
    }

}