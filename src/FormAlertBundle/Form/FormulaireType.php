<?php
// src/FormAlertBundle/Form/Type/FormulaireType.php
namespace FormAlertBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class FormulaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('phone', TextType::class, [
                'label' => 'Téléphone',
                'data' => 'Téléphone'
            ])
            ->add('lastname', TextType::class, ['required' => false, 'label' => 'Nom' , 'attr' => ['readonly' => true]])
            ->add('firstname', TextType::class, ['required' => false, 'label' => 'Prénom', 'attr' => ['readonly' => true]])
            ->add('custom1', TextType::class, ['required' => false , 'label' => 'Champ personnalisé 1'])
            ->add('custom2', TextType::class, ['required' => false , 'label' => 'Champ personnalisé 2'])
            ->add('custom3', TextType::class, ['required' => false , 'label' => 'Champ personnalisé 3'])
            ->add('custom4', TextType::class, ['required' => false , 'label' => 'Champ personnalisé 4'])
            ->add('nom_formulaire', TextType::class, ['label' => 'Nom du Formulaire']);
    }

  
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' => 'FormAlertBundle\Entity\Formulaire',
           'constraints' => [
               new Callback([$this, 'validate']),
           ],
        ]);
    }

    private function normalizeString($string)
    {
        // Remove accents and convert to lowercase
        $normalized = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);
        return strtolower(trim($normalized));
    }

    public function validate($data, ExecutionContextInterface $context)
    {
        $fields = ['lastname', 'firstname', 'custom1', 'custom2', 'custom3', 'custom4'];
        $values = [];
        $existingFields = ['nom' => 'lastname', 'prénom' => 'firstname'];
    
        $phoneVariations = ['phone', 'tel', 'tél', 'telephone', 'téléphone'];
    
        foreach ($fields as $field) {
            $value = $data->{'get'.ucfirst($field)}();
            if ($value) {
                $normalizedValue = $this->normalizeString($value);
    
                // Allow using "Nom" in the lastname field without triggering duplication
                if ($normalizedValue === 'nom' && $field === 'lastname') {
                    continue;
                }
    
                if (in_array($normalizedValue, array_map([$this, 'normalizeString'], $phoneVariations))) {
                    $context->buildViolation('Utilisez le champ "Téléphone" existant.')
                        ->atPath($field)
                        ->addViolation();
                    continue;
                }
    
                if (isset($values[$normalizedValue])) {
                    $context->buildViolation('Duplication de la valeur : '.$value)
                        ->atPath($field)
                        ->addViolation();
                    $context->buildViolation('Duplication de la valeur : '.$value)
                        ->atPath($values[$normalizedValue])
                        ->addViolation();
                } elseif (isset($existingFields[$normalizedValue]) && $existingFields[$normalizedValue] !== $field) {
                    $context->buildViolation('La valeur "' . $value . '" a déjà un bouton existant. Utilisez le bouton dédié.')
                        ->atPath($field)
                        ->addViolation();
                } else {
                    $values[$normalizedValue] = $field;
                }
            }
        }
    }
}
