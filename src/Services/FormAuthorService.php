<?php

namespace App\Services;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\TestFormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Authors;
use App\Entity\Books;

class FormAuthorService extends AbstractController
{
    public $error = null;
 
    public function create($form, $author)
    {
        // Устанвливаем данные из формы
        $data = $form->getData();
        if(strlen($data['surname']) < 3) {
            return $this->error = 'Слишком короткая фамилия';
        }
        $em = $this->getDoctrine()->getManager();
        $author->setName($data['name']);
        $author->setSurname($data['surname']);
        $em->persist($author);
        $em->flush();
        return true;
    }

}