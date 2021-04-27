<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\TestFormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Books;
use App\Entity\Authors;
use App\Services\FormBookService;

class BookController extends AbstractController
{
    /**
     * @Route("/view/{authorid}", name="viewbooks")
     */
    public function index(int $authorid, Request $request)
    {
        $author = $this->getDoctrine()->getRepository(Authors::class)->find($authorid);
        $books = $this->getDoctrine()->getRepository(Books::class)->findBy(['author' => $authorid]);
        return $this->render('view/index.html.twig', array(
            'books' => $books, 'author' => $author, 'authorid' => $authorid,
        ));
    }

    /**
     * @Route("/changebook/{bookid}", name="changebook")
     */
    public function change(int $bookid, Request $request, FormBookService $formAdd)
    {
        // Получаем данные книги
        $book = $this->getDoctrine()
        ->getRepository(Books::class)->find($bookid);
        // Получаем id автора для редиректа
        $authorid = $book->getAuthor($bookid)->getId();
        $form = $this->createForm(TestFormType::class);
        // Создаем поля для формы
        $form->add('name', TextType::class, array('label' => 'Название книги', 'attr' => array('value' => $book->getBookName())))
        ->add('date', TextType::class, array('label' => 'Дата выхода книги', 'attr' => array('value' => $book->getBookDate())));
        // Создаем форму
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $formAdd->create($form, $book);
            if($formAdd->error) {
                return $this->render('changeBook/index.html.twig', array(
                    'form' => $form->createView(), 'error' => $formAdd->error,
                ));
            }
            else {
                return $this->redirect("/view/$authorid");
            }
        }
        return $this->render('changeBook/index.html.twig', array(
            'form' => $form->createView(), 'error' => $formAdd->error,
        ));
    }

     /**
     * @Route("/addbook/{authorid}", name="addbook")
     */
    public function add(int $authorid, Request $request, FormBookService $formAdd)
    {
        // Получаем данные автора
        $author = $this->getDoctrine()->getRepository(Authors::class)->find($authorid);
        $book = new Books;
        $form = $this->createForm(TestFormType::class);
        // Создаем поля для формы
        $form->add('name', TextType::class, array('label' => 'Нзвание книги'))
        ->add('date', TextType::class, array('label' => 'Дата выхода'));
        //Создаем форму
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $formAdd->create($form, $book, $author);
            if($formAdd->error) {
                return $this->render('addBook/index.html.twig', array(
                    'form' => $form->createView(), 'error' => $formAdd->error,
                ));
            }
            else{
                return $this->redirect("/view/$authorid");
            }
        }
        return $this->render('addBook/index.html.twig', array(
            'form' => $form->createView(), 'error' => $formAdd->error,
        ));
    }

    /**
     * @Route("/deletebook/{bookid}", name="deletebook")
     */
    public function delete(int $bookid, Request $request)
    {
        // Получаем данные книги и удаляем ее
        $book = $this->getDoctrine()
        ->getRepository(Books::class)->find($bookid);
        $em = $this->getDoctrine()->getManager();
        $em->remove($book);
        $em->flush();
        // Отправляем на пред страницу
        $authorid = $book->getAuthor($bookid)->getId();
        return $this->redirect("/view/$authorid");
    }
}