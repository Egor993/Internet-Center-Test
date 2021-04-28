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
use App\Exception\FormException;


class FormAuthorService extends AbstractController
{
    // Валидирует форму и создает ее
    public function create(array $data, object $author)
    {
        // Если фамилия < 3 символов - создаем исключение
        if(mb_strlen($data['surname']) < 3) {
            throw new FormException('Слишком короткая фамилия');
        }
        // Устанвливаем данные из формы
        $em = $this->getDoctrine()->getManager();
        $author->setName($data['name']);
        $author->setSurname($data['surname']);
        $em->persist($author);
        $em->flush();
        return true;
    }

}