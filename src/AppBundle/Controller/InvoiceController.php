<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Invoice;
use Symfony\Component\HttpFoundation\Response;


class InvoiceController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        # TODO: Paginação
        $orçamentos = $this->getDoctrine()
            ->getRepository('AppBundle:Invoice')
            ->findAll();

        return $this->render('invoices/index.html.twig', array(
            'items' => $orçamentos,
            'title' => 'Orçamentos'
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function addAction(Request $request)
    {
        $invoice = new Invoice();
        $form = $this->createForm('AppBundle\Form\Type\InvoiceType', $invoice);
        $form->handleRequest($request);

        if ($form->isValid()) {
            /* NOTE: it isn't need to persist InvoiceItem objects.
            These are cascated by "parent" Entity (Invoice) */
            $em = $this->getDoctrine()->getManager();
            $em->persist($invoice);
            $em->flush();

            return $this->redirectToRoute('invoices');
        }

        return $this->render('invoices/add.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Novo orçamento'
        ));
    }

    public function showAction($id)
    {
        $invoice = $this->getDoctrine()->getRepository('AppBundle:Invoice')
            ->find($id);

        return $this->render('invoices/show.html.twig', array(
            'title' => 'Dados da invoice #' . $invoice->getId(),
            'invoice' => $invoice,
        ));
    }
}
