<?php
// src/AppBundle/Form/UserType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, [
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'control-label'],
            ])
            ->add('phoneNumber', null, [
                'label' => 'Numéro de téléphone',
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'control-label'],
            ])
            ->add('champ1', null, [
                'label' => 'Champ 1',
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'control-label'],
            ])
            ->add('champ2', null, [
                'label' => 'Champ 2',
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'control-label'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\User',
            'csrf_protection' => false,
        ]);
    }
}