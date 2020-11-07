<?php

namespace App\Controller;

use App\Service\GetFromApiService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{

    /**
     * @Route("/", name="index")
     */
    public function index(GetFromApiService $serviceGet): Response
    {
        $characters = $serviceGet->getCharacters();
        return $this->render('blog/index.html.twig',[
            'characters' => $characters
        ]);
    }


    /**
     * @Route("/post/{id}", name="details")
     */
    public function details(int $id): Response
    {
        return $this->render('blog/details.html.twig',[
            'id' => $id
        ]);
    }
}
