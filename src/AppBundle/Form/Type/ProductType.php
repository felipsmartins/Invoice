<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('price', 'Symfony\Component\Form\Extension\Core\Type\MoneyType', array(
                'currency' => 'BRL',
            ))
            ->add('currentQuantity', 'Symfony\Component\Form\Extension\Core\Type\IntegerType')
            ->add('description', 'Symfony\Component\Form\Extension\Core\Type\TextareaType')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Product',
        ));
    }

    public function getBlockPrefix()
    {
        return 'product';
    }
}