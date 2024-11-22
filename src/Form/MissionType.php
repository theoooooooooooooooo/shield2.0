<?php

namespace App\Form;

use App\Entity\Mission;
use App\Entity\MissionStatus;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('status', EnumType::class,[
                'class' => MissionStatus::class,
                // 'choice_label' => string,    
            ])
            ->add('startAt', null, [
                'widget' => 'single_text'
            ])
            ->add('endAt', null, [
                'widget' => 'single_text'
            ])
            ->add('location')
            ->add('dangerLevel')
            ->add('assignedTeam', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mission::class,
        ]);
    }
}
