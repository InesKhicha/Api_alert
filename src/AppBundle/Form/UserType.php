<?php
// src/AppBundle/Form/UserType.php
namespace AppBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $formulaire = $options['formulaire'];

        $builder
            ->add('tel', TextType::class, [
                'label' => 'Téléphone',
                'required' => true,
            ]);

        if ($formulaire->getCustom1()) {
            $builder->add('custom1', TextType::class, [
                'label' => $formulaire->getCustom1(),
                'required' => false,
            ]);
        }

        if ($formulaire->getCustom2()) {
            $builder->add('custom2', TextType::class, [
                'label' => $formulaire->getCustom2(),
                'required' => false,
            ]);
        }

        if ($formulaire->getCustom3()) {
            $builder->add('custom3', TextType::class, [
                'label' => $formulaire->getCustom3(),
                'required' => false,
            ]);
        }

        if ($formulaire->getCustom4()) {
            $builder->add('custom4', TextType::class, [
                'label' => $formulaire->getCustom4(),
                'required' => false,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\User',
            'formulaire' => null,
        ]);
    }
}
