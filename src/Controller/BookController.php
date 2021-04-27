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
     * @Route("/view", name="view_books")
     */
    public function index(Request $request)
    {
        $author_id = $request->query->get('author_id');
        $author = $this->getDoctrine()->getRepository(Authors::class)->find($author_id);
        $books = $this->getDoctrine()->getRepository(Books::class)->findBy(['author' => $author_id]);
        return $this->render('view/index.html.twig', array(
            'books' => $books, 'author' => $author, 'author_id' => $author_id,
        ));
    }

    /**
     * @Route("/change_book", name="change_book")
     */
    public function change(Request $request, FormBookService $form_add)
    {
        // Получаем данные книги
        $book_id = $request->query->get('book_id');
        $book = $this->getDoctrine()
        ->getRepository(Books::class)->find($book_id);
        // Получаем id автора для редиректа
        $author_id = $book->getAuthor($book_id)->getId();
        $form = $this->createForm(TestFormType::class);
        // Создаем поля для формы
        $form->add('name', TextType::class, array('label' => 'Название книги', 'attr' => array('value' => $book->getBookName())))
        ->add('date', TextType::class, array('label' => 'Дата выхода книги', 'attr' => array('value' => $book->getBookDate())));
        // Создаем форму
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $form_add->create($form, $book);
            if($form_add->error) {
                return $this->render('changeBook/index.html.twig', array(
                    'form' => $form->createView(), 'error' => $form_add->error,
                ));
            }
            else {
                return $this->redirect("/view?author_id=$author_id");
            }
        }
        return $this->render('changeBook/index.html.twig', array(
            'form' => $form->createView(), 'error' => $form_add->error,
        ));
    }

     /**
     * @Route("/addbook/{author_id}", name="add_book")
     */
    public function add(int $author_id, Request $request, FormBookService $form_add)
    {
        // Получаем данные автора
        // $author_id = $request->query->get('author_id');
        $author = $this->getDoctrine()->getRepository(Authors::class)->find($author_id);
        $book = new Books;
        $form = $this->createForm(TestFormType::class);
        // Создаем поля для формы
        $form->add('name', TextType::class, array('label' => 'Нзвание книги'))
        ->add('date', TextType::class, array('label' => 'Дата выхода'));
        //Создаем форму
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $form_add->create($form, $book, $author);
            if($form_add->error){
                return $this->render('addBook/index.html.twig', array(
                    'form' => $form->createView(), 'error' => $form_add->error,
                ));
            }
            else{
                return $this->redirect("/view?author_id=".$author_id);
            }
        }
        return $this->render('addBook/index.html.twig', array(
            'form' => $form->createView(), 'error' => $form_add->error,
        ));
    }

    /**
     * @Route("/delete_book", name="delete_book")
     */
    public function delete(Request $request)
    {
        // Получаем данные книги и удаляем ее
        $book_id = $request->query->get('book_id');
        $book = $this->getDoctrine()
        ->getRepository(Books::class)->find($book_id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($book);
        $em->flush();
        // Отправляем на пред страницу
        $author_id = $book->getAuthor($book_id)->getId();
        return $this->redirect("/view?author_id=$author_id");
    }
}