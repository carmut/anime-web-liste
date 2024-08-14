<?php

namespace App\Controller;

use App\Entity\Anime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomePageController extends AbstractController
{
    #[Route('', name: 'app_home_page')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // récuperation liste des animes
        $anime = $entityManager->getRepository(Anime::class)->findAll();

        // récupération liste en cour de parrution
        $anime_parrution = $entityManager->getRepository(Anime::class)->findBy(array('statut' => 1),array('day_episode_release'=>'ASC','hour_episode_release'=> 'ASC'));
        // tableau liste sortie du jour
        $anime_parrution_today = [];
        // tableau liste sortie autre jour 
        $anime_parrution_other_day = [];

        $date_jour = date('N');
        foreach ($anime_parrution as $parrution) {
            
            if ($parrution->getDayEpisodeRelease() == $date_jour) {
                array_push($anime_parrution_today, $parrution);
            }else {
                array_push($anime_parrution_other_day, $parrution);
            }
        }

        // definition anime de presentation
        $anime_pres = $anime[rand(0,(count($anime)-1))];
        $pres_titre = $anime_pres->getName();
        $pres_descr = $anime_pres->getDescription();
        $pres_image = $anime_pres->getImageLink();
        $pres_link  = $anime_pres->getLien();
        $pres_site  = $anime_pres->getSite();
        $pres_id    = $anime_pres->getId();
        // définition couleur du bouton ['couleur btn' , 'couleur texte']
        $liste_couleur_btn = [
            'crunchyroll' => ['#f47521','#141519'],
            'netflix' => ['#e50914','#141519'],
            'amazon' => ['#00a8e1','#141519'],
            'disney' => ['#113ccf','#141519'],
            'youtube' => ['#ff0000','#141519'],
            'adn' => ['#0095ff','#141519'],
        ];

        return $this->render('home_page/index.html.twig', [
            'pres_anime_titre' => $pres_titre,
            'pres_anime_description' => $pres_descr,
            'pres_anime_image' => $pres_image,
            'pres_anime_lien' => $pres_link,
            'pres_anime_site' => $pres_site,
            'liste_color_btn' => $liste_couleur_btn,
            'liste_animes' => $anime,
            'liste_parrution_today' => $anime_parrution_today,
            'liste_parrution_other_day' => $anime_parrution_other_day,
            'pres_id' => $pres_id,
        ]);
    }
}
