<?php

namespace App\Form;

use App\Entity\Anime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class AnimeAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $genres = [
            'principaux' => [
                'action' => 'action',
                'fantaisie' => 'fantaisie',
                'tranche de vie' => 'tranche de vie',
            ],
            'secondaire' => [
                'adulte' => 'adulte',
                'isekai' => 'isekai',
            ],                    
        ];
        $statut = [
            'non-définie' => null,
            'en cours de diffusion' => '1',
            'saison terminer' => '0',
        ];
        $site = [
            'non-définie' => null,
            'crunchyroll' => 'crunchyroll',
            'ADN' => 'adn',
            'Netflix' => 'netflix',
            'disney +' => 'disney',
            'Youtube' => 'youtube',
        ];
        $day = [
            'pas encore connu' => null,
            'lundis' => '1',
            'mardis' => '2',
            'mercredis' => '3',
            'jeudis' => '4',
            'vendredis' => '5',
            'samedis' => '6',
            'dimanche' => '7',
        ];

        $builder
            ->add('name')
            ->add('genre', ChoiceType::class, [
                'choices' => $genres,
                'multiple' => true,
                'expanded' => true,
                'choice_attr' => function($choice, $key, $value) use ($genres) {
                    foreach ($genres as $group => $choices) {
                        if (in_array($value, $choices)) {
                            return ['data-group' => $group];
                        }
                    }
                    return [];
                },
            ])
            ->add('episodeNumber')
            ->add('description')
            ->add('lien')
            ->add('site', ChoiceType::class, [
                'choices' => $site,
                'expanded' => true,
            ])
            ->add('image_link', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/jpeg',
                            'application/png',
                            'application/jpe',
                            'application/avif',
                            'application/jpg'
                        ],
                        'mimeTypesMessage' => 'selectionner une image valide',
                    ])
                ]
            ])
            ->add('statut', ChoiceType::class, [
                'choices' => $statut,
                'expanded' => true,

            ])
            ->add('day_episode_release', ChoiceType::class, [
                'choices' => $day,
                'expanded' => true,
            ])
            ->add('hour_episode_release', null, [
                'widget' => 'single_text',
            ])
            ->add('ajouter', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Anime::class,
        ]);
    }
}
