<?php
// src/FormAlertBundle/Form/FileContentType.php
namespace FormAlertBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FileContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $formulaire = $options['formulaire'];

        // Liste des pays avec leurs indicatifs
        $countryChoices = [
            '+33' => 'France (+33)',
            '+32' => 'Belgique (+32)',
            '+41' => 'Suisse (+41)',
            '+352' => 'Luxembourg (+352)',
            '+49' => 'Allemagne (+49)',
            '+39' => 'Italie (+39)',
            '+34' => 'Espagne (+34)',
            '+44' => 'Royaume-Uni (+44)',
            '+212' => 'Maroc (+212)',
            '+213' => 'Algérie (+213)',
            '+216' => 'Tunisie (+216)',
            '+221' => 'Sénégal (+221)',
            '+225' => 'Côte d\'Ivoire (+225)',
            '+1' => 'Canada (+1)',
            '+86' => 'Chine (+86)',
            '+91' => 'Inde (+91)',
            '+81' => 'Japon (+81)',
            '+61' => 'Australie (+61)',
            '+55' => 'Brésil (+55)',
            // Ajoutez d'autres pays ici
        ];

        // Trier les pays par ordre alphabétique de leurs noms
        asort($countryChoices);

        $builder
        ->add('country_code', ChoiceType::class, [
            'choices' => $countryChoices,
            'data' => '+33', // Par défaut sur la France
            'required' => true,
            'mapped' => false,
            'label' => 'Indicatif pays',
        ])
        ->add('phone', TextType::class, [
            'required' => true,
            'constraints' => [
                new Assert\Callback([
                    'callback' => function($object, $context) {
                        $countryCode = $context->getRoot()->get('country_code')->getData();
                        $phone = $object;
                        if (!empty($phone)){
                        switch ($countryCode) {
                            case '+33': // France
                                if (!preg_match('/^0?[1-9][0-9]{8}$/', $phone)) {
                                    $context->buildViolation('Veuillez entrer un numéro de téléphone français valide (ex: 0123456789).')
                                        ->addViolation();
                                }
                                break;
                            case '+32': // Belgique
                            case '+41': // Suisse
                                if (!preg_match('/^0?[1-9][0-9]{8}$/', $phone)) {
                                    $context->buildViolation('Veuillez entrer un numéro de téléphone valide (ex: 0123456789).')
                                        ->addViolation();
                                }
                                break;
                            case '+352': // Luxembourg
                                if (!preg_match('/^[2-9]\d{7}$/', $phone)) {
                                    $context->buildViolation('Veuillez entrer un numéro de téléphone luxembourgeois valide (ex: 27123456).')
                                        ->addViolation();
                                }
                                break;
                            case '+49': // Allemagne
                                if (!preg_match('/^0?[1-9][0-9]{9,11}$/', $phone)) {
                                    $context->buildViolation('Veuillez entrer un numéro de téléphone allemand valide (ex: 01512345678).')
                                        ->addViolation();
                                }
                                break;
                            case '+39': // Italie
                            case '+34': // Espagne
                                if (!preg_match('/^[0-9]{9,10}$/', $phone)) {
                                    $context->buildViolation('Veuillez entrer un numéro de téléphone valide (9 à 10 chiffres).')
                                        ->addViolation();
                                }
                                break;
                            case '+44': // Royaume-Uni
                                if (!preg_match('/^0?[1-9][0-9]{9}$/', $phone)) {
                                    $context->buildViolation('Veuillez entrer un numéro de téléphone britannique valide (ex: 07911123456).')
                                        ->addViolation();
                                }
                                break;
                            case '+212': // Maroc
                            case '+213': // Algérie
                            case '+216': // Tunisie
                            case '+221': // Sénégal
                            case '+225': // Côte d'Ivoire
                                if (!preg_match('/^[0-9]{8,9}$/', $phone)) {
                                    $context->buildViolation('Veuillez entrer un numéro de téléphone valide (8 à 9 chiffres).')
                                        ->addViolation();
                                }
                                break;
                            case '+1': // Canada
                                if (!preg_match('/^[2-9]\d{2}[2-9]\d{2}\d{4}$/', $phone)) {
                                    $context->buildViolation('Veuillez entrer un numéro de téléphone canadien valide (ex: 5141234567).')
                                        ->addViolation();
                                }
                                break;
                            case '+86': // Chine
                                if (!preg_match('/^[1-9]\d{10}$/', $phone)) {
                                    $context->buildViolation('Veuillez entrer un numéro de téléphone chinois valide (ex: 13800138000).')
                                        ->addViolation();
                                }
                                break;
                            case '+91': // Inde
                                if (!preg_match('/^[6-9]\d{9}$/', $phone)) {
                                    $context->buildViolation('Veuillez entrer un numéro de téléphone indien valide (ex: 9123456789).')
                                        ->addViolation();
                                }
                                break;
                            case '+81': // Japon
                                if (!preg_match('/^[1-9]\d{8,9}$/', $phone)) {
                                    $context->buildViolation('Veuillez entrer un numéro de téléphone japonais valide (ex: 09012345678).')
                                        ->addViolation();
                                }
                                break;
                            case '+61': // Australie
                                if (!preg_match('/^0?[2-478][0-9]{8}$/', $phone)) {
                                    $context->buildViolation('Veuillez entrer un numéro de téléphone australien valide (ex: 0412345678).')
                                        ->addViolation();
                                }
                                break;
                            case '+55': // Brésil
                                if (!preg_match('/^[1-9]\d{9}$/', $phone)) {
                                    $context->buildViolation('Veuillez entrer un numéro de téléphone brésilien valide (ex: 11987654321).')
                                        ->addViolation();
                                }
                                break;
                            default:
                                if (!preg_match('/^[0-9]{6,14}$/', $phone)) {
                                    $context->buildViolation('Veuillez entrer un numéro de téléphone valide (6 à 14 chiffres).')
                                        ->addViolation();
                                }
                        }}
                    },
                ]),
            ],
            'label' => 'Numéro de téléphone',
        ]);
        
        // Ajoutez les champs personnalisés
        if ($formulaire->getLastname()) {
            $builder->add('lastname', TextType::class, [
                'label' => $formulaire->getLastname(),
                'required' => false,
                'constraints' => [
                    new Assert\Length([
                        'max' => 32,
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
                        'max' => 32,
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
            'data_class' => 'FormAlertBundle\Entity\FileContent',
            'formulaire' => null,
            'csrf_protection' => false, // Activez la protection CSRF
        ]);
    }
}
