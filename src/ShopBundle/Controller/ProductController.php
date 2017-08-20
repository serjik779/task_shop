<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        #$productsSin = $this->getDoctrine()->getRepository(Products::class);
        $products = $em->getRepository('ShopBundle:Products')->findAll();

        return $this->render('ShopBundle:products:index.html.twig', array(
            'products' => $products,

        ));
    }
    public function showAction(Products $product) {
        $em = $this->getDoctrine()->getManager();

        #$productsSin = $this->getDoctrine()->getRepository(Products::class);



        return $this->render('ShopBundle:products:show.html.twig', array(
            'product' => $product,
        ));
    }
}
