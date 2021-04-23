<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\TestFormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Authors;
use App\Entity\Books;
use App\Services\FormAuthorService;

class AuthorController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        //Получаем список авторов
        $authors = $this->getDoctrine()
        ->getRepository(Authors::class)->findAll();

        return $this->render('main/index.html.twig', array(
            'authors' => $authors,
        ));
    }

    /**
     * @Route("/add_author", name="add_author")
     */
    public function add(Request $request, FormAuthorService $form_add )
    {
        // Создаем поля
        $form = $this->createForm(TestFormType::class);
        $form->add('name', TextType::class, array('label' => 'Имя'))
        ->add('surname', TextType::class, array('label' => 'Фамилия'));
        $author = new Authors;
        // Создаем форму
        if($form_add->create($request, $form, $author)){
            return $this->redirect('/');
        }
        return $this->render('addAuthor/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/change_author", name="change_author")
     */
    public function change(Request $request, FormAuthorService $form_add )
    {
        // Получаем данные автора и создаем форму
        $author_id = $request->query->get('author_id');
        $author = $this->getDoctrine()
        ->getRepository(Authors::class)->find($author_id);
        $form = $this->createForm(TestFormType::class);
        // Создаем поля для формы
        $form->add('name', TextType::class, array('label' => 'Имя', 'attr' => array('value' => $author->getName())))
        ->add('surname', TextType::class, array('label' => 'Фамилия', 'attr' => array('value' => $author->getSurname())));
        // Создаем форму
        if($form_add->create($request, $form, $author)){
            return $this->redirect('/');
        }
        return $this->render('changeAuthor/index.html.twig', array(
            'form' => $form->createView(), 
        ));
    }
}