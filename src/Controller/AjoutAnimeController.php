<?php

namespace App\Controller;

use App\Entity\Anime;
use App\Form\AnimeAddType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AjoutAnimeController extends AbstractController
{
    #[Route('ajout', name: 'app_ajout_anime')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $anime = new Anime();
        $form = $this->createForm(AnimeAddType::class, $anime);
        $form->handleRequest($request);
           
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($anime);
            $entityManager->flush();

            return $this->redirectToRoute('app_ajout_anime' ,[], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('ajout_anime/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
