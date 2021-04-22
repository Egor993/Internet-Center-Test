<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\TestFormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Authors;

class AddAuthorController extends AbstractController
{
    /**
     * @Route("/add_author", name="add_author")
     */
    public function index(Request $request)
    {
        // Создаем поля и получаем данные из формы
        $form = $this->createForm(TestFormType::class);
        $form->add('name', TextType::class, array('label' => 'Имя'))
        ->add('surname', TextType::class, array('label' => 'Фамилия'));
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            // Устанвливаем данные из формы
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $author = new Authors;
            $author->setName($data['name']);
            $author->setSurname($data['surname']);
            $em->persist($author);
            $em->flush();
            return $this->redirect('/');
        }
        
        return $this->render('addAuthor/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }


}