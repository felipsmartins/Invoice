<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('customer', 'entity', array(
                'class' => 'AppBundle:Customer',
                'placeholder' => '',
            ))
            ->add('notes', 'textarea')
            ->add('items', 'collection', array(
                'type'           => new InvoiceItemType(),
                'allow_add'      => true, # Permitir adição de vários campos extras
                'allow_delete'   => true, # Permitir adição de campos existentes
                'by_reference'   => false,
                'prototype_name' => '_INVOICEITEM_NAME_', # placeholder (ver JS)
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Invoice',
        ));
    }

    public function getName()
    {
        return 'invoice_form';
    }
}