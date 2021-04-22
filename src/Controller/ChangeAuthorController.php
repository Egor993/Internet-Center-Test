<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\TestFormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Authors;
use App\Entity\Books;

class ChangeAuthorController extends AbstractController
{
    /**
     * @Route("/change_author", name="change_author")
     */
    public function index(Request $request)
    {
        // Получаем данные автора и создаем форму
        $id = $request->query->get('id');
        $author = $this->getDoctrine()
        ->getRepository(Authors::class)->find($id);
        $name = $author->getName();
        $surname = $author->getSurname();
        $form = $this->createForm(TestFormType::class);
        // Создаем поля для формы
        $form->add('name', TextType::class, array('label' => 'Имя', 'attr' => array('value' => "$name")))
        ->add('surname', TextType::class, array('label' => 'Фамилия', 'attr' => array('value' => "$surname")));
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            // Устанвливаем данные из формы
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $author->setName($data['name']);
            $author->setSurname($data['surname']);
            $em->persist($author);
            // Меняем автора в книгах
            $books = $this->getDoctrine()
            ->getRepository(Books::class)->findBy( ['authorName' => "$name", 'authorSurname' => "$surname"]);
            foreach($books as $book) {
                $book->setAuthorName($data['name']);
                $book->setAuthorSurname($data['surname']);
                $em->persist($book);
            }
            // Сохраняем и отправляем на главную
            $em->flush();
            return $this->redirect('/');
        }
        
        return $this->render('changeAuthor/index.html.twig', array(
            'form' => $form->createView(), 
        ));
    }


}