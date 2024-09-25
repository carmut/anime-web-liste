<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DeleteController extends AbstractController
{
    #[Route('/delete/{id}', name: 'app_delete')]
    public function index(): Response
    {
        return $this->render('delete/index.html.twig', [
            'controller_name' => 'DeleteController',
        ]);
    }
}
