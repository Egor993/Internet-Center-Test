<?php

namespace App\Controller;

use App\Entity\Authors;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    public function index()
    {
        //Получаем список авторов
        $authors = $this->getDoctrine()
        ->getRepository(Authors::class)->findAll();

        return $this->render('main/index.html.twig', array(
            'authors' => $authors,
        ));
    }
}