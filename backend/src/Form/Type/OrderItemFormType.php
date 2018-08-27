<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class OrderItemFormType
 * @package App\Form\Type
 */
class OrderItemFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product', TextType::class, [
                'required' => true,
                'constraints' => [new NotBlank()],
            ])
            ->add('quantity', IntegerType::class, [
                'required' => true,
                'constraints' => [new NotBlank()],
            ]);
    }

}