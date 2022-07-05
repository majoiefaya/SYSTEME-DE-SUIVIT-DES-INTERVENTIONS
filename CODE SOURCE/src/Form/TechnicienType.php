<?php

namespace App\Form;

use App\Entity\Technicien;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TechnicienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('CreerPar')
            ->add('CreerLe')
            ->add('ModifierPar')
            ->add('ModifierLe')
            ->add('Enable')
            ->add('SupprimerPar')
            ->add('SupprimerLe')
            ->add('Nom')
            ->add('Prenom')
            ->add('Age')
            ->add('Sexe')
            ->add('Telephone')
            ->add('Adresse')
            ->add('Email')
            ->add('MotDePasse')
            ->add('Roles')
            ->add('Fonction')
            ->add('Statut')
            ->add('Type')
            ->add('equipe')
            ->add('chef')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Technicien::class,
        ]);
    }
}
