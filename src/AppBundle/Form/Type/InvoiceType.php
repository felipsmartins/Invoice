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
            ->add('customer', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                'class' => 'AppBundle:Customer',
                'placeholder' => '',
            ))
            ->add('notes', 'Symfony\Component\Form\Extension\Core\Type\TextareaType')
            ->add('items', 'Symfony\Component\Form\Extension\Core\Type\CollectionType', array(
                'entry_type'     => 'AppBundle\Form\Type\InvoiceItemType',
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

    public function getBlockPrefix()
    {
        return 'invoice_form';
    }
}