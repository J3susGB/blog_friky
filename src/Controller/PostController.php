<?php

namespace App\Controller;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PostController extends AbstractController {
    
    private $em;

    public function __construct(EntitymanagerInterface $em) {
        $this->em = $em;
    }

    #[Route('/post/{id?0}', name: 'app_post')]
    public function index($id): Response
    {

        $posts = $this->em->getRepository(Post::class)->findBy(['id' => 1, 'titulo' => 'Mi primer post de prueba']);

        if (!$posts) {
            throw $this->createNotFoundException("Post no encontrado");
        }

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }
}
