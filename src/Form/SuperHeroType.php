<?php

namespace App\Form;

use App\Entity\Pouvoir;
use App\Entity\SuperHero;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SuperHeroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('alterEgo')
            ->add('estDisponible', ChoiceType::class, [
                'label' => 'Disponibilité',
                'choices' => [
                    'Disponible' => 1,
                    'Non Disponible' => 0,
                ],
                'expanded' => true, // Boutons radio
                'multiple' => false, // Un seul choix possible
            ])
            ->add('energieLevel')
            ->add('biographie')
            // ->add('imageNom')
            ->add('createdAt', null, [
                'widget' => 'single_text'
            ])
            ->add('pouvoirs', EntityType::class, [
                'class' => Pouvoir::class,
                'choice_label' => 'nom', // Affiche le nom des pouvoirs
                'multiple' => true, // Permet plusieurs sélections
                'expanded' => true, // Utilise des cases à cocher
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SuperHero::class,
        ]);
    }
}
