<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConfidentialityController extends AbstractController
{
    #[Route('/confidentiality', name: 'confidentiality')]
    public function index(): Response
    {
        return $this->render('confidentiality/index.html.twig', [
            'controller_name' => 'ConfidentialityController',
        ]);
    }
}
