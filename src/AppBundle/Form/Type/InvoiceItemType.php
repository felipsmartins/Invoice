<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                'class' => 'AppBundle:Product',
                'placeholder' => 'Selecinar',
            ))
            ->add('productPrice', 'Symfony\Component\Form\Extension\Core\Type\HiddenType', array(
                'mapped' => false,
            ))
            ->add('quantity', 'Symfony\Component\Form\Extension\Core\Type\IntegerType')
            ->add('totalPrice', 'Symfony\Component\Form\Extension\Core\Type\MoneyType', array(
                'currency' => 'BRL'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\InvoiceItem',
        ));
    }

    public function getBlockPrefix()
    {
        return 'invoice_product';
    }
}