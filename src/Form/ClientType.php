<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('gender', ChoiceType::class, [
                'label' => false,
                'choices'=> ['Mr' => false, 'Mme' => true],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('fname', TextType::class, [
                    'label' => 'Prénom',
                    'attr' => ['class'=>'form-control']
                ]
            )
            ->add('lname',TextType::class, [
                'label' => 'Nom',
                'attr' => ['class'=>'form-control']
            ])

            ->add('city',TextType::class, [
                'label' => 'Ville',
                'attr' => ['class'=>'form-control']
            ])
            ->add('adress',TextType::class, [
                'label' => 'Adresse',
                'attr' => ['class'=>'form-control']
            ])
            ->add('email',EmailType::class, [
                'label' => 'Email',
                'required' => false,
                'attr' => ['class'=>'form-control']
            ])
            ->add('phone', NumberType::class,[
                'label' => 'Téléphone',
                'required' => false,
                'attr' => ['class'=>'form-control']
            ])
            ->add('isCasseCouille', CheckboxType::class, [
                'label' => 'Casse couille ?',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
