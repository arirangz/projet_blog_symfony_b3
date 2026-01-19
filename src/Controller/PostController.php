<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PostController extends AbstractController
{
    #[Route('/post/{id}', name: 'app_post_show')]
    public function show(Post $post, Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $comment = new Comment();
        $commentForm = $this->createForm(CommentForm::class, $comment);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $entityManagerInterface->persist($comment);

            $entityManagerInterface->flush();
        }
        
        return $this->render('post/show.html.twig', [
            'post' => $post,
            'commentForm' => $commentForm,
        ]);
    }
}
