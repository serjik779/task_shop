<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SingleProductController extends Controller
{
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        #$productsSin = $this->getDoctrine()->getRepository(Products::class);
        $SinProduct = $em->getRepository('ShopBundle:Products');

        return $this->render('ShopBundle:single-product:index.html.twig', array(
            'product-single' => $SinProduct,
        ));
    }
}
