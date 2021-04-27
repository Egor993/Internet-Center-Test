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
use Symfony\Component\Config\Definition\Exception\Exception;

class FormAuthorService extends AbstractController
{
    public function create(array $data, object $author)
    {
        // Устанвливаем данные из формы
        if(mb_strlen($data['surname']) < 3) {
            throw new Exception();
        }
        $em = $this->getDoctrine()->getManager();
        $author->setName($data['name']);
        $author->setSurname($data['surname']);
        $em->persist($author);
        $em->flush();
        return true;
    }

}