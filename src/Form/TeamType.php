<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\Mission;
use App\Entity\SuperHero;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('estActive', ChoiceType::class, [
                'label' => 'Active',
                'choices' => [
                    'Actif' => 1,
                    'Non Actif' => 0,
                ],
                'expanded' => true, // Boutons radio
                'multiple' => false, // Un seul choix possible
            ])
            ->add('createdAt', null, [
                'widget' => 'single_text'
            ])
            ->add('leader', EntityType::class, [
                'class' => SuperHero::class,
                'choice_label' => 'nom',])
            ->add('members', EntityType::class, [
                'class' => SuperHero::class,
                'choice_label' => 'nom ',
                'multiple' => true, 
                'expanded' => true, ])
            ->add('currentMission', EntityType::class, [
                'class' => Mission::class,
                'choice_label' => 'titre',]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}
