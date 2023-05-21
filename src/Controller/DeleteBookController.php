<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;

class DeleteBookController extends AbstractController
{
    #[Route('/delete/book/{authorid}/{id}', name: 'app_delete_book')]
    public function index(int $id, int $authorid, BookRepository $BookRepository,  Request $request): Response
    {
        $BookRepository->remove($BookRepository->find($id), true);
        return $this->redirectToRoute('app_author', ['id' => $authorid]);
    }
}
