<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\TestFormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Books;

class AddBookController extends AbstractController
{
    /**
     * @Route("/addBook", name="add_book")
     */
    public function index(Request $request)
    {
        // Получаем данные автора
        $author_id = $request->query->get('id');
        $author_name = $request->query->get('author_name');
        $author_surname = $request->query->get('author_surname');
        $form = $this->createForm(TestFormType::class);
        // Создаем поля для формы
        $form->add('name', TextType::class, array('label' => 'Нзвание книги'))
        ->add('date', TextType::class, array('label' => 'Дата выхода'));
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            // Устанвливаем данные из формы
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $author = new Books;
            $author->setAuthorName($author_name);
            $author->setAuthorSurname($author_surname);
            $author->setBookName($data['name']);
            $author->setBookDate($data['date']);
            $em->persist($author);
            $em->flush();
            // Отправляем на пред страницу
            return $this->redirect("/view?id=$author_id");
        }
        
        return $this->render('addBook/index.html.twig', array(
            'form' => $form->createView()
        ));
    }


}