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
            ->add('product', 'entity', array(
                'class' => 'AppBundle:Product',
                'placeholder' => 'Selecinar',
            ))
            ->add('productPrice', 'hidden', array(
                'mapped' => false,
            ))
            ->add('quantity', 'integer')
            ->add('totalPrice', 'money', array(
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

    public function getName()
    {
        return 'invoice_product';
    }
}