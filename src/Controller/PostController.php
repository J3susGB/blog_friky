<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    // Método para insertar datos en la BBDD

    #[Route('/insert/post', name: 'insert_post')]
    public function insert() {
        $post = new Post('Mi post insertado', 'opinion', 'Otro hola mundo más', 'holita.jpg', 'hola-mundo-insertado');
        $user = $this->em->getRepository(User::class)->find(1);
        $post->setUser($user);

        $this->em->persist($post);
        $this->em->flush();
        return new JsonResponse(['success' => true]);
    }

    // Método para editar datos en la BBDD

    #[Route('/update/post', name: 'update_post')]
    public function update() {
        $post = $this->em->getRepository(Post::class)->find(3);
        $post->setTitulo('Mi nuevo titulo editado');

        $this->em->flush();
        return new JsonResponse(['success' => true]);
    }

    // Método para eliminar datos en la BBDD

    #[Route('/remove/post', name: 'remove_post')]
    public function remove() {
        $post = $this->em->getRepository(Post::class)->find(4);
        $this->em->remove($post);

        $this->em->flush();
        return new JsonResponse(['success' => true]);
    }
}
