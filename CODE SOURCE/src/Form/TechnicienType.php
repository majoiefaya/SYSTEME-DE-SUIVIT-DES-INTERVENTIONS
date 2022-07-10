<?php

namespace App\Form;

use App\Entity\Technicien;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class TechnicienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
            ->add('Nom')
            ->add('Prenom')
            ->add('Age')
            ->add('Sexe')
            ->add('Telephone')
            ->add('Adresse')
            ->add('Email')
            ->add('MotDePasse')
            ->add('Fonction')
            ->add('Statut')
            ->add('Type')
            ->add('Image', FileType::class, ['mapped'=>false,'attr'=>['name'=>'image','required'=>false]]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Technicien::class,
        ]);
    }
}
