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
     * @Route("/addauthor", name="addauthor")
     */
    public function add(Request $request, FormAuthorService $formAdd )
    {
        // Создаем поля
        $form = $this->createForm(TestFormType::class);
        $form->add('name', TextType::class, array('label' => 'Имя'))
        ->add('surname', TextType::class, array('label' => 'Фамилия'));
        $author = new Authors;
        // Создаем форму
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $formAdd->create($form, $author);
            if($formAdd->error) {
                return $this->render('addAuthor/index.html.twig', array(
                    'form' => $form->createView(), 'error' => $formAdd->error,
                ));
            }
            else {
                return $this->redirect('/');
            }
        }
        return $this->render('addAuthor/index.html.twig', array(
            'form' => $form->createView(), 'error' => $formAdd->error,
        ));
    }

    /**
     * @Route("/changeauthor/{authorid}", name="changeauthor")
     */
    public function change(int $authorid, Request $request, FormAuthorService $formAdd )
    {
        // Получаем данные автора и создаем форму
        $author = $this->getDoctrine()
        ->getRepository(Authors::class)->find($authorid);
        $form = $this->createForm(TestFormType::class);
        // Создаем поля для формы
        $form->add('name', TextType::class, array('label' => 'Имя', 'attr' => array('value' => $author->getName())))
        ->add('surname', TextType::class, array('label' => 'Фамилия', 'attr' => array('value' => $author->getSurname())));
        // Создаем форму
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $formAdd->create($form, $author);
            if($formAdd->error) {
                return $this->render('changeAuthor/index.html.twig', array(
                    'form' => $form->createView(), 'error' => $formAdd->error,
                ));
            }
            else {
                return $this->redirect('/');
            }
        }
        return $this->render('changeAuthor/index.html.twig', array(
            'form' => $form->createView(), 'error' => $formAdd->error,
        ));
    }
}