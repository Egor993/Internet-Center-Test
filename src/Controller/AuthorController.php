<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\TestFormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Author;
use App\Services\FormAuthorService;

class AuthorController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request)
    {
        //Создаем форму поиска
        $form = $this->createForm(TestFormType::class)->add('search', TextType::class, array('label' => 'Поиск автора'));
        $data = $form->handleRequest($request)->getData();
        if ($form->isSubmitted()) {
            if(!(preg_match('/.*\s/', $data['search'], $name)) and (!(preg_match('/.*/', $data['search'], $name)))){
                $name = [0 => ''];
            }
            if(!(preg_match('/\s.*/', $data['search'], $surname)) and (!(preg_match('/.*/', $data['search'], $surname)))){
                $surname = [0 => ''];
            }
            $authors = $this->getDoctrine()
            ->getRepository(Author::class)->findAuthor(trim($name[0]), trim($surname[0]));
        }
        else {
            //Получаем список всех авторов
            $authors = $this->getDoctrine()
            ->getRepository(Author::class)->findAll();
        }
        return $this->render('main/index.html.twig', array(
            'authors' => $authors, 'form' => $form->createView()
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
        $author = new Author;
        // Создаем форму
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            try {
                $formAdd->create($form->getData(), $author);
                return $this->redirect('/');
            }
            catch(\Exception $e) {
                return $this->render('addAuthor/index.html.twig', array(
                    'form' => $form->createView(), 'error' => 'Слишком короткая фамилия',
                ));
            }
        }
        return $this->render('addAuthor/index.html.twig', array(
            'form' => $form->createView(), 'error' => null,
        ));
    }

    /**
     * @Route("/changeauthor/{authorId}", name="changeauthor")
     */
    public function change(int $authorId, Request $request, FormAuthorService $formAdd )
    {
        // Получаем данные автора и создаем форму
        $author = $this->getDoctrine()
        ->getRepository(Author::class)->find($authorId);
        $form = $this->createForm(TestFormType::class);
        // Создаем поля для формы
        $form->add('name', TextType::class, array('label' => 'Имя', 'attr' => array('value' => $author->getName())))
        ->add('surname', TextType::class, array('label' => 'Фамилия', 'attr' => array('value' => $author->getSurname())));
        // Создаем форму
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            $data = $form->getData();
            try {
                $formAdd->create($form->getData(), $author);
                return $this->redirect('/');
            }
            catch(\Exception $e) {
                return $this->render('changeAuthor/index.html.twig', array(
                    'form' => $form->createView(), 'error' => 'Слишком короткая фамилия',
                ));  
            }
        }
        return $this->render('changeAuthor/index.html.twig', array(
            'form' => $form->createView(), 'error' => null,
        ));
    }
}