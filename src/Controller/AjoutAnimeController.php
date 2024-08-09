<?php

namespace App\Controller;

use App\Entity\Anime;
use App\Form\AnimeAddType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AjoutAnimeController extends AbstractController
{
    #[Route('ajout', name: 'app_ajout_anime')]
    public function index(Request $request, EntityManagerInterface $entityManager,SluggerInterface $slugger,
    #[Autowire('%kernel.project_dir%/public/images/imageanime')] string $imagedirectory
    ): Response
    {
        $anime = new Anime();
        $form = $this->createForm(AnimeAddType::class, $anime);
        $form->handleRequest($request);
           
        if ($form->isSubmitted() && $form->isValid()){
            $imagefile = $form->get('image_link')->getData();
            if($imagefile){
                $originalFilename = pathinfo($imagefile->getClientOriginalName(), PATHINFO_FILENAME);
                
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imagefile->guessExtension();

                try {
                    $imagefile->move($imagedirectory, $newFilename);
                } catch (FileException $e) {
                    
                }
            }

            $anime->setImageLink('images/imageanime/'+$newFilename);

            // fin upload
            $entityManager->persist($anime);
            $entityManager->flush();

            return $this->redirectToRoute('app_ajout_anime' ,[], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('ajout_anime/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
