<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\TestFormType;
use App\Entity\Books;

class DeleteBookController extends AbstractController
{
    /**
     * @Route("/delete_book", name="delete_book")
     */
    public function index(Request $request)
    {
        $author_id = $request->query->get('author_id');
        // Получаем данные книги и удаляем ее
        $id = $request->query->get('id');
        $book = $this->getDoctrine()
        ->getRepository(Books::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($book);
        $em->flush();
        // Отправляем на пред страницу
        return $this->redirect("/view?id=$author_id");

    }


}