<?php

namespace App\Controller;

use App\Entity\Author;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EditAuthorController extends AbstractController
{
    #[Route('/edit/author/{id}', defaults: ['id' => 0], name: 'app_edit_author')]
    public function handle(int $id, AuthorRepository $authorRepository, Request $request): Response 
    {

        $currentAuthor = ($id) ? $authorRepository->find($id) : new Author;
        $form = $this->createFormBuilder($currentAuthor, ['attr' => ['class' => 'form']])
            ->add('firstName', TextType::class, ['label' => 'Имя', 'attr' => ['class' => 'input']])
            ->add('secondName', TextType::class, ['label' => 'Фамилия', 'attr' => ['class' => 'input']])
            ->add('save', SubmitType::class, ['label' => 'Сохранить изменения', 'attr' => ['class' => 'btn']])
            ->getForm();

        $form->handleRequest($request);  

        if ($form->isSubmitted() && $form->isValid()) {
            $authorRepository->save($currentAuthor, true);
            return $this->redirectToRoute('index');
        }       

        return $this->render('edit_author/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
