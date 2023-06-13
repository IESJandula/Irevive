<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('c/index.html.twig', [
            'controller_name' => 'CController',
        ]);
    }

    #[Route('/contacto', name: 'app_contacto')]
    public function contacto(): Response
    {
        return $this->render('c/contacto.html.twig', [
            'controller_name' => 'CController',
        ]);
    }
}
