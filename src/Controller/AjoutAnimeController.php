<?php

namespace App\Controller;

use App\Entity\Anime;
use App\Form\AnimeAddType;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
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

            $imageUrl = $anime->getImageLink();

            // Validation de l'URL de l'image
            if (filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                $client = new Client();
                $response = $client->get($imageUrl, ['stream' => true]);

                if ($response->getStatusCode() == 200) {
                    $contentType = $response->getHeaderLine('Content-Type');
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if (in_array($contentType, $allowedTypes)) {
                        $extension = explode('/', $contentType)[1];
                        $imageName = uniqid() . '.' . $extension;
                        $imagePath = $this->getParameter('kernel.project_dir') . '/public/images/' . $imageName;

                        // Sauvegarder l'image sur le serveur
                        file_put_contents($imagePath, $response->getBody()->getContents());

                        // Mettre à jour l'URL de l'image avec le chemin local
                        $anime->setImageLink('/images/' . $imageName);
                    } else {
                        $this->addFlash('error', 'Le type de fichier n\'est pas supporté.');
                    }
                } else {
                    $this->addFlash('error', 'Impossible de télécharger l\'image.');
                }
            } else {
                $this->addFlash('error', 'URL invalide ou non supportée.');
            }

            $entityManager->persist($anime);
            $entityManager->flush();

            return $this->redirectToRoute('app_ajout_anime' ,[], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('ajout_anime/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
