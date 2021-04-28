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

class FormBookService extends AbstractController
{
    // Валидирует форму и создает ее
    public function create(array $data, object  $book, object $author = null) : object
    {
        // Создаем исключение, если дата > 2100 года
        if($data['date'] > 2100) {
            throw new FormException('Слишком длинная дата');
        }
        // Устанавливаем данные из формы
        $em = $this->getDoctrine()->getManager();
        if($author) {
            $book->setAuthor($author);
        }
        $book->setBookName($data['name']);
        $book->setBookDate($data['date']);
        $em->persist($book);
        $em->flush();
        // Возвращаем объект модели
        return $book;
    }

}