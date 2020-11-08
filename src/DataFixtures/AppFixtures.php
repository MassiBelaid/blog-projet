<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Comment;
use App\Entity\Character;
use Doctrine\Persistence\ObjectManager;
use function Symfony\Component\String\u;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\HttpClient\HttpClient;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://rickandmortyapi.com/api/character/');

        $faker = \Faker\Factory::create('fr_FR');

        $statusCode = $response->getStatusCode();


        $admin = new User();
        $admin->setEmail("admin@blog.fr")
            ->setUsername("admin")
            ->setPassword("\$2y$13\$Gxv1XDaT5d1mIzjeCeXxZOhXYBavauUq.YMGfO8MwJdg0SFLpOSG6")
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

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
                            ->setImage($characterString['image'])
                            ->setFisrtSeen($firstSeen);

                            $manager->persist($character);


                //Commentaire pour le character
                for($z = 0; $z < mt_rand(4,10); $z++){
                    $commentaire = new Comment();
                    $user = new User();
                    $user->setEmail($faker->freeEmail())
                        ->setUsername($faker->name())
                        ->setPassword($faker->password());
                    $manager->persist($user);

                    $commentaire->setContent($faker->paragraph())
                                ->setCreatedAt($faker->dateTimeBetween('-24 months'))
                                ->setCharacterr($character)
                                ->setUser($user);
                    $manager->persist($commentaire);
                }
            }
        //}
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
        }
    }
}
