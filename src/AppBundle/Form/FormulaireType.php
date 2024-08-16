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
            ->add('phone', TextType::class, [
                'label' => 'Téléphone',
                'data' => 'Téléphone'
            ])
            ->add('lastname', TextType::class, ['required' => false, 'label' => 'Nom'])
            ->add('firstname', TextType::class, ['required' => false, 'label' => 'Prénom'])
            ->add('custom1', TextType::class, ['required' => false , 'label' => 'Champ personnalisé 1'])
            ->add('custom2', TextType::class, ['required' => false , 'label' => 'Champ personnalisé 2'])
            ->add('custom3', TextType::class, ['required' => false , 'label' => 'Champ personnalisé 3'])
            ->add('custom4', TextType::class, ['required' => false , 'label' => 'Champ personnalisé 4'])
            ->add('nom_formulaire', TextType::class, ['label' => 'Nom du Formulaire']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' => 'AppBundle\Entity\Formulaire',
        ]);
    } 
}
