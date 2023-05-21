<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BookRepository;
use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\Request;

class EditBookController extends AbstractController
{
    #[Route('/edit/book/{authorid}/{id}', defaults: ['id' => 0], name: 'app_edit_book')]
    public function index(int $id, int $authorid, BookRepository $BookRepository, AuthorRepository $AuthorRepository, Request $request): Response 
    {

        $currentBook = ($id) ? $BookRepository->find($id) : new Book;
        $currentBook->setAuthor($AuthorRepository->find($authorid));
        $author = $AuthorRepository->find($authorid);
        if ($id) {
            $currentBook = $BookRepository->find($id);
        } else {
            $currentBook = new Book;
            $currentBook->setAuthor($author); 
        }

        $form = $this->createFormBuilder($currentBook, ['attr' => ['class' => 'form']])
            ->add('Name', TextType::class, ['label' => 'Название', 'attr' => ['class' => 'input']])
            ->add('Year', IntegerType::class, ['label' => 'Год', 'attr' => ['class' => 'input']])
            ->add('save', SubmitType::class, ['label' => 'Сохранить изменения', 'attr' => ['class' => 'btn']])
            ->getForm();

        $form->handleRequest($request);  

        if ($form->isSubmitted() && $form->isValid()) {
            $BookRepository->save($currentBook, true);
            return $this->redirectToRoute('index');
        }       

        return $this->render('edit_book/index.html.twig', [
            'form' => $form->createView(),
            'author' => $author
        ]);
    }
}
