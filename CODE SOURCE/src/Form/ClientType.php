<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\AddressType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom')
            ->add('Prenom')
            ->add('Age')
            ->add('Sexe', ChoiceType::class, [
                'choices' => [
                    'placeholder' => 'choisir une option',
                    'Homme' => "Homme",
                    'Femme' => "Femme",
                    'Autres' => "Autres",
                    'required'=>"True",
                    'name'=>"sexe"
                ]])
            ->add('Telephone',TelType::class,['attr'=>[
                'id'=>'phone',
                'name'=>'phone',
                'required'=>true
            ]])
            ->add('Adresse',AddressType::class, [
                'label_format' => 'form.Address.%name%',
            ])
            ->add('Email')
            ->add('MotDePasse',PasswordType::class, [
                'label_format' => 'form.Address.%name%',
            ])
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
