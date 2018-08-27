<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class OrderFormType.
 */
class OrderFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('items', CollectionType::class, [
                'entry_type' => OrderItemFormType::class,
                'allow_add' => true,
                'constraints' => [new NotBlank()],
                'required' => true
            ])
            ->add('notes', TextareaType::class, [
                'constraints' => [new NotBlank()],
            ]);
    }
}
