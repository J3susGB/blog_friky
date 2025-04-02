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

        $posts = $this->em->getRepository(Post::class)->find($id);
        $custom_post = $this->em->getRepository(Post::class)->findPost($id); //Metedo persanilazo creado en PostRepository

        if (!$posts) {
            throw $this->createNotFoundException("Post no encontrado");
        }

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
            'custom_post' => $custom_post
        ]);
    }
}
