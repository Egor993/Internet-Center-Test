<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\TestFormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Books;

class ChangeBookController extends AbstractController
{
    /**
     * @Route("/change_book", name="change_book")
     */
    public function index(Request $request)
    {
        // Получаем id автора для редиректа
        $author_id = $request->query->get('author_id');
        // Получаем данные книги и создаем форму
        $id = $request->query->get('id');
        $book = $this->getDoctrine()
        ->getRepository(Books::class)->find($id);
        $name = $book->getBookName();
        $date = $book->getBookDate();
        $form = $this->createForm(TestFormType::class);
        // Создаем поля для формы
        $form->add('name', TextType::class, array('label' => 'Название книги', 'attr' => array('value' => "$name")))
        ->add('date', TextType::class, array('label' => 'Дата выхода книги', 'attr' => array('value' => "$date")));
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            // Устанвливаем данные из формы
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $book->setBookName($data['name']);
            $book->setBookDate($data['date']);
            $em->persist($book);
            $em->flush();
            // Отправляем на пред страницу
            return $this->redirect("/view?id=$author_id");
        }
        
        return $this->render('changeBook/index.html.twig', array(
            'form' => $form->createView(), 
        ));
    }


}