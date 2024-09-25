<?php

namespace App\Controller;

use App\Entity\Anime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class InfosController extends AbstractController
{
    #[Route('/infos/{id}', name: 'app_infos')]
    public function index(string $id,EntityManagerInterface $entityManager): Response
    {   
        $id = (int) $id;
        $Anime = $entityManager->getRepository(Anime::class)->findBy(['id' => $id]);
        $infosAnime = $Anime[0];

        $titre = $infosAnime->getName();
        $description = $infosAnime->getdescription();
        $image = $infosAnime->getImageLink();
        $site = $infosAnime->getSite();
        $lien = $infosAnime->getLien();
        $statut = $infosAnime->getStatut();
        $day = $infosAnime->getDayEpisodeRelease();
        $hour = $infosAnime->getHourEpisodeRelease();
        $episodes = $infosAnime->getepisodeNumber();

        //affichage
        return $this->render('infos/index.html.twig', [
            'titre' =>  $titre,
            'description' =>  $description,
            'image' =>  $image,
            'site' =>  $site,
            'lien' =>  $lien,
            'statut' =>  $statut,
            'day' =>  $day,
            'hour' =>  $hour,
            'episodes' =>  $episodes,
            'id' => $id,
        ]);
    }
}
