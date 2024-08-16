<?php
// src/AppBundle/Form/FileContentType.php
// src/AppBundle/Form/FileContentType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

class FileContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $formulaire = $options['formulaire'];

        $builder
            ->add('phone', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Regex([
                        'pattern' => '/^\+?[0-9]{10,15}$/',
                        'message' => 'Veuillez entrer un numéro de téléphone valide.',
                    ]),
                ],
            ]);

       
            if ($formulaire->getLastname()) {
                $builder->add('lastname', TextType::class, [
                    'label' => $formulaire->getLastname(),
                    'required' => false,
                    'constraints' => [
                        new Assert\Length([
                            'max' => 255,
                            'maxMessage' => 'Le champ ne peut pas dépasser {{ limit }} caractères.',
                        ]),
                    ],
                ]);
            }

            if ($formulaire->getFirstname()) {
                $builder->add('firstname', TextType::class, [
                    'label' => $formulaire->getFirstname(),
                    'required' => false,
                    'constraints' => [
                        new Assert\Length([
                            'max' => 255,
                            'maxMessage' => 'Le champ ne peut pas dépasser {{ limit }} caractères.',
                        ]),
                    ],
                ]);
            }


            if ($formulaire->getCustom1()) {
            $builder->add('custom1', TextType::class, [
                'label' => $formulaire->getCustom1(),
                'required' => false,
                'constraints' => [
                    new Assert\Length([
                        'max' => 255,
                        'maxMessage' => 'Le champ ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ],
            ]);
        }

        if ($formulaire->getCustom2()) {
            $builder->add('custom2', TextType::class, [
                'label' => $formulaire->getCustom2(),
                'required' => false,
                'constraints' => [
                    new Assert\Length([
                        'max' => 255,
                        'maxMessage' => 'Le champ ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ],
            ]);
        }

        if ($formulaire->getCustom3()) {
            $builder->add('custom3', TextType::class, [
                'label' => $formulaire->getCustom3(),
                'required' => false,
                'constraints' => [
                    new Assert\Length([
                        'max' => 255,
                        'maxMessage' => 'Le champ ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ],
            ]);
        }

        if ($formulaire->getCustom4()) {
            $builder->add('custom4', TextType::class, [
                'label' => $formulaire->getCustom4(),
                'required' => false,
                'constraints' => [
                    new Assert\Length([
                        'max' => 255,
                        'maxMessage' => 'Le champ ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ],
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\FileContent',
            'formulaire' => null,
            'csrf_protection' => false, // Activez la protection CSRF
        ]);
    }
}