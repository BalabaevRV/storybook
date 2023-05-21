<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class IndexController extends AbstractController
{
    #[Route('/', 'index')]
    public function handle(AuthorRepository $authorRepository): Response 
    {
        $authors = $authorRepository->findAll();
        return $this->render('index.html.twig', [
            'authors' => $authors
        ]);
    }
}
