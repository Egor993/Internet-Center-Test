<?php

namespace App\Controller\Api;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Author;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/authors", name="apiAuthors")
     */
    // Отображает главную страницу со списком авторов в json формате
    public function authorView(Request $request)
    {
        // Получаем список авторов
        $authors = $this->getDoctrine()
        ->getRepository(Author::class)->findAll();
        // Преобразуем список в json формат
        foreach($authors as $val) {
        $arr[] = [
         'id' => $val->getId(),
         'name' => $val->getName(),
         'surname' => $val->getSurname()];
        }
        return new JsonResponse($arr);
    }
}

