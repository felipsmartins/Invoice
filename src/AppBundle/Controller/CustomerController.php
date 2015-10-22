<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Customer;
use AppBundle\Form\Type\CustomerType;

class CustomerController extends Controller
{
    /**
     * List
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        # TODO: pagination
        $customers = $this->getDoctrine()
            ->getRepository('AppBundle:Customer')
            ->findAll();

        return $this->render('customers/index.html.twig', array(
            'items' => $customers,
            'title' => 'Clientes'
        ));
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function addAction(Request $request)
    {
        $customer = new Customer();
        $form = $this->createForm(new CustomerType(), $customer);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

            return $this->redirectToRoute('customers');
        }

        return $this->render(':customers:add.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Novo cliente'
        ));
    }
}
