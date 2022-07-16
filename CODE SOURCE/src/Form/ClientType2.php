<?php

namespace App\Form;

use App\Entity\Client;
// lib/form/ContactForm.class.php
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints as Assert;

class ClientType2 extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom')
            ->add('Prenom')
            ->add('Age')
            ->add('Sexe', ChoiceType::class, [
                'choices' => [
                    'Homme' => "Homme",
                    'Femme' => "Femme",
                    'Autres' => "Autres",
                ],'attr'=>['name'=>'sexe','required'=>true]])
            // ->add('Telephone',TelType::class,['attr'=>[
            //     'id'=>'phone',
            //     'name'=>'phone',
            //     'required'=>true
            // ]])
            ->add('Adresse', ChoiceType::class, [
                'choices' => [
                    'Lome-Togo' => "Lome-Togo",
                    'Kara-Togo' => "Kara-Togo",
                    'Sokode-Togo' => "Sokode-Togo",
                    'Dapaong-Togo' => "Dapaong-Togo",
                ]
            ,'attr'=>['name'=>'Addresse','required'=>true]])
            ->add('Email',EmailType::class,[
                    'label' => 'Email',
                    'constraints' =>[
                        new Assert\Email([
                            'message'=>'Format du Mail Incorrect'
                        ]),
                        new Assert\NotBlank([
                            'message' => 'Ce champ ne peut etre vide'
                        ])
                    ],'attr'=>['name'=>'Email','required'=>true]
                ])
            ->add('MotDePasse',PasswordType::class)
            ->add('Image', FileType::class, ['mapped'=>false,'attr'=>['name'=>'image','required'=>false]]);
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
