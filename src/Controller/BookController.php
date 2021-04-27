<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\TestFormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Book;
use App\Entity\Author;
use App\Services\FormBookService;
use Symfony\Component\Config\Definition\Exception\Exception;

class BookController extends AbstractController
{
    /**
     * @Route("/view/{authorId}", name="viewbooks")
     */
    public function index(int $authorId, Request $request)
    {
        $author = $this->getDoctrine()->getRepository(Author::class)->find($authorId);
        $books = $this->getDoctrine()->getRepository(Book::class)->findBy(['author' => $authorId]);
        return $this->render('view/index.html.twig', array(
            'books' => $books, 'author' => $author, 'authorId' => $authorId,
        ));
    }

    /**
     * @Route("/changebook/{bookId}", name="changebook")
     */
    public function change(int $bookId, Request $request, FormBookService $formAdd)
    {
        // Получаем данные книги
        $book = $this->getDoctrine()
        ->getRepository(Book::class)->find($bookId);
        // Получаем id автора для редиректа
        $authorId = $book->getAuthor($bookId)->getId();
        $form = $this->createForm(TestFormType::class);
        // Создаем поля для формы
        $form->add('name', TextType::class, array('label' => 'Название книги', 'attr' => array('value' => $book->getBookName())))
        ->add('date', TextType::class, array('label' => 'Дата выхода книги', 'attr' => array('value' => $book->getBookDate())));
        // Создаем форму
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            try {
                $formAdd->create($form->getData(), $book);
                return $this->redirect("/view/$authorId");    
            }
            catch(\Exception $e) {
                return $this->render('changeBook/index.html.twig', array(
                    'form' => $form->createView(), 'error' => 'Слишком длинная дата'
                ));
            }
        }
        return $this->render('changeBook/index.html.twig', array(
            'form' => $form->createView(), 'error' => null
        ));
    }

     /**
     * @Route("/addbook/{authorId}", name="addbook")
     */
    public function add(int $authorId, Request $request, FormBookService $formAdd)
    {
        // Получаем данные автора
        $author = $this->getDoctrine()->getRepository(Author::class)->find($authorId);
        $book = new Book;
        $form = $this->createForm(TestFormType::class);
        // Создаем поля для формы
        $form->add('name', TextType::class, array('label' => 'Нзвание книги'))
        ->add('date', TextType::class, array('label' => 'Дата выхода'));
        //Создаем форму
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            try {
                $formAdd->create($form->getData(), $book, $author);
                return $this->redirect("/view/$authorId");
            }
            catch(\Exception $e) {
            return $this->render('addBook/index.html.twig', array(
                'form' => $form->createView(), 'error' => 'Слишком длинная дата'
            ));
            }
        }
        return $this->render('addBook/index.html.twig', array(
            'form' => $form->createView(), 'error' => $formAdd->error, 'authorId' => $authorId
        ));
    }

    /**
     * @Route("/deletebook/{bookId}", name="deletebook")
     */
    public function delete(int $bookId, Request $request)
    {
        // Получаем данные книги и удаляем ее
        $book = $this->getDoctrine()
        ->getRepository(Book::class)->find($bookId);
        $em = $this->getDoctrine()->getManager();
        $em->remove($book);
        $em->flush();
        // Отправляем на пред страницу
        $authorId = $book->getAuthor($bookId)->getId();
        return $this->redirect("/view/$authorId");
    }
}