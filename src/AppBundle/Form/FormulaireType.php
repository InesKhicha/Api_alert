<?php
// src/AppBundle/Form/Type/FormulaireType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FormulaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tel', TextType::class, [
                'label' => 'Téléphone',
                'disabled' => true,
                'data' => 'Téléphone'
            ])
            ->add('custom1', TextType::class, ['required' => false])
            ->add('custom2', TextType::class, ['required' => false])
            ->add('custom3', TextType::class, ['required' => false])
            ->add('custom4', TextType::class, ['required' => false])
            ->add('nom_formulaire', TextType::class, ['label' => 'Nom du Formulaire']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Formulaire',
        ]);
    }
}
