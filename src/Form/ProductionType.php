<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Production;;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ProductionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('project', EntityType::class, [
                'class' => Project::class,
                'choice_label' => 'name',
                'choice_attr' => function ($project) {
                    if($project->getDeliveryDate() !== null) {
                        return ['disabled' => 'disabled'];
                    } 
                    return ['enabled' => 'enabled'];
                },
                'label' => 'Projet'
            ])
            ->add('nbDays', NumberType::class, [
                'label' => 'Nombre de jours'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Production::class,
        ]);
    }
}