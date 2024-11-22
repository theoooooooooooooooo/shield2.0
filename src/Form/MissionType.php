<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\Mission;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\MissionStatus;

class MissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'En Attente' => MissionStatus::PENDING,
                    'Commencée' => MissionStatus::IN_PROGRESSE,
                    'Terminée' => MissionStatus::COMPLETED,
                    'Échoué' => MissionStatus::FAIELD,
                ],
                'choice_label' => fn($choice) => $choice->value, // Affiche la valeur de l'enum
            ])
            ->add('startAt', null, [
                'widget' => 'single_text',
            ])
            ->add('endAt', null, [
                'widget' => 'single_text',
            ])
            ->add('location')
            ->add('dangerLevel')
            ->add('assignedTeam', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'nom', // ou un autre attribut descriptif
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mission::class,
        ]);
    }
}
