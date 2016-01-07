<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\Product;

class ProductController extends Controller
{
    /**
     * List
     *
     * @return Response
     */
    public function indexAction()
    {
        # TODO: pagination
        $products = $this->getDoctrine()
            ->getRepository('AppBundle:Product')
            ->findAll();

        return $this->render('products/index.html.twig', array(
            'items' => $products,
            'title' => 'Produtos'
        ));
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function addAction(Request $request)
    {
        $product = new product();
        $form = $this->createForm('AppBundle\Form\Type\ProductType', $product);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('products');
        }

        return $this->render('products/add.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Novo produto'
        ));
    }

    /**
     * Query url:
     *    format: json
     *    id: id
     * @param Request $request
     *
     * @return Response
     */
    public function getProductInfoAction(Request $request)
    {
        $productId = $request->query->get('id');
        $format = $request->query->get('format');
        $product = $this->getDoctrine()->getRepository('AppBundle:Product')
            ->find($productId);
        # Ajax?
        if ('json' == $format) {
            $data = array(
                'id'               => $product->getId(),
                'name'             => $product->getName(),
                'description'      => $product->getDescription(),
                'price'            => $product->getPrice(),
                'current_quantity' => $product->getCurrentQuantity(),
                'created_at'       => $product->getCreatedAt()->format('d-m-Y H:i'),
            );
            return new JsonResponse($data, 200, array(
                'Content-type' => 'application/json'
            ));
        }

        # twig?
        return new Response('A ser implementado...');
    }
}
