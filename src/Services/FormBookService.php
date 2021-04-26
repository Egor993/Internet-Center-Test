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

class FormBookService extends AbstractController
{

    public $error = null;
 
    public function create($form, $book, $author = null)
    {
        // Устанвливаем данные из формы
        $data = $form->getData();
        if($data['date'] > 2100) {
            return $this->error = 'Слишком длинная дата';
        }
        $em = $this->getDoctrine()->getManager();
        if($author) {
            $book->setAuthor($author);
        }
        $book->setBookName($data['name']);
        $book->setBookDate($data['date']);
        $em->persist($book);
        $em->flush();
        return true;
    }

}