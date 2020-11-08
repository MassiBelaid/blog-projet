<?php

namespace App\Controller;


use App\Entity\Comment;
use App\Entity\Character;
use App\Form\CommentType;
use App\Repository\CharacterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     * @Route("/show{id}", name="character_show")
     */
    public function character_show(Character $character, Request $request, EntityManagerInterface $manager): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);


        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $comment->setCreatedAt(new \DateTime())
                    ->setCharacterr($character)
                    ->setUser($this->getUser());
                    
            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('character_show',[
                'id' => $character->getId()
            ]);
        }
        
        return $this->render('blog/info.html.twig',[
            'character' => $character,
            'formComment' => $form->createView()
        ]);
    }



    /**
     * @Route("/home", name="home")
     */
    public function home(CharacterRepository $repository, Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $repository->findAll();

        $characters = $paginator->paginate($donnees, 
                                         $request->query->getInt('page',1),
                                         4   );

        return $this->render('blog/home.html.twig',[
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
