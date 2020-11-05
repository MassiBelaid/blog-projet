<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{

    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('blog/index.html.twig');
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
