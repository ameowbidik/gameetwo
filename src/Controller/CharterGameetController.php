<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CharterGameetController extends AbstractController
{
    #[Route('/charter/gameet', name: 'charter_gameet')]
    public function index(): Response
    {
        return $this->render('charter_gameet/index.html.twig', [
            'controller_name' => 'CharterGameetController',
        ]);
    }
}
