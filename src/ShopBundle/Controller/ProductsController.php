<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Categories;
use ShopBundle\Entity\Images;
use ShopBundle\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ProductsController extends Controller
{
//    public function indexAction(Request $request) {
//        $em = $this->getDoctrine()->getManager();
//
//        #$productsSin = $this->getDoctrine()->getRepository(Products::class);
//        $products = $em->getRepository('ShopBundle:Products')->findAll();
//
//        $paginator  = $this->get('knp_paginator');
//        $productsPagination = $paginator->paginate(
//            $products, /* query NOT result */
//            $request->query->getInt('page', 1)/*page number*/,
//            $this->container->getParameter('page_limit')
//        );
//
//        return $this->render('ShopBundle:products:index.html.twig', array(
//            'products' => $productsPagination,
//            'category' => array()
//        ));
//    }
//    public function showAction(Products $product) {
//        $em = $this->getDoctrine()->getManager();
//
//        #$productsSin = $this->getDoctrine()->getRepository(Products::class);
//        $relatedProducts = $em->getRepository(Products::class)->findBy(['category' => $product->getCategory()->getId()],[],10);
//
//
//        return $this->render('ShopBundle:products:show.html.twig', array(
//            'product' => $product,
//            'relatedProducts' => $relatedProducts
//        ));
//    }
    /**
     * @Template()
     */
    public function indexAction(Request $request)
    {
//        $model1 = $this->get('doctrine')->getManager()->getRepository(Products::class)->findAll();
        $model2 = $this->get('doctrine')->getManager()->getRepository(Categories::class)->findAll();
        $vm = $this->get('shop.product_view_model_assembler')->generateViewModel($model2);
//        return $this->render('ShopBundle:products:index.html.twig' , array(
//            'vm' => $vm
        return array(
            'vm' => $vm,
        );
    }
}
