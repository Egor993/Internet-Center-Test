<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\TestFormType;
use App\Entity\Books;
use App\Entity\Authors;

class ViewBooksController extends AbstractController
{
    /**
     * @Route("/view", name="view_books")
     */
    public function index(Request $request)
    {
        $id = $request->query->get('id');
        // Получаем данные автора и его книг
        $author = $this->getDoctrine()
        ->getRepository(Authors::class)->find($id);
        $name = $author->getName();
        $surname = $author->getSurname();
        $books = $this->getDoctrine()
        ->getRepository(Books::class)->findBy( ['authorName' => "$name", 'authorSurname' => "$surname"]);
        return $this->render('view/index.html.twig', array(
            'books' => $books, 'author_name' => $name, 'author_surname' => $surname, 'id' => $id
        ));
    }


}