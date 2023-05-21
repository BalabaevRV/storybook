<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;

class AuthorController extends AbstractController
{
    #[Route('/author/{id}', name: 'app_author')]
    public function index(int $id, AuthorRepository $authorRepository, BookRepository $BookRepository): Response
    {
        $currentAuthor = $authorRepository->find($id);
        $books = $BookRepository->findBy(['author' => $id]);
        return $this->render('author/index.html.twig', [
            'author' => $currentAuthor,
            'books' => $books
        ]);
    }
}
