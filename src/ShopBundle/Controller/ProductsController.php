<?php

namespace ShopBundle\Controller;

use Doctrine\ORM\EntityManager;
use ShopBundle\Entity\Categories;
use ShopBundle\Entity\Products;
use ShopBundle\Entity\Wishlist;
use ShopBundle\ShopBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductsController extends Controller
{
    public function indexAction(Request $request)
    {
        $model = $this->get('doctrine.orm.entity_manager')
            ->getRepository('ShopBundle:Categories')
            ->findAll(); //all categories

        $vm = $this->get('shop.categories_view_model_assembler')->generateViewModel($model);

        $paginator = $this->get('knp_paginator');
        $categoriesPagination = $paginator->paginate(
            $model, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $this->container->getParameter('page_limit')
        );
        
        return $this->render('ShopBundle:products:index.html.twig', array(
            'vm' => $vm,
            'category' => $categoriesPagination
        ));
    }

    public function showCategoryAction(Request $request, Categories $categories)
    {
        $model = $this->get('doctrine.orm.entity_manager')
            ->getRepository('ShopBundle:Products')
            ->findBy([
                'category' => $categories->getId(),
            ]); // Category items.


        $vm = $this->get('shop.product_view_model_assembler')->generateViewModel($model);

        $paginator = $this->get('knp_paginator');
        $productsPagination = $paginator->paginate(
            $model, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $this->container->getParameter('page_limit')
        );

        return $this->render('ShopBundle:products:category.html.twig', array(
                'vm' => $vm,
                'product' => $productsPagination,
                'category' => $categories,
            )
        );
    }

    public function showSingleAction(Request $request, Products $products)
    {
        $model = $this->get('doctrine')
            ->getManager()
            ->getRepository(Products::class)
            ->findBy(['category' => $products->getCategory()->getId()], [], 10); //related products
        $vm = $this->get('shop.relprod_view_model_assembler')->generateViewModel($model);

        return $this->render('ShopBundle:products:single.html.twig', array
        (
            'product' => $products,
            'vm' => $vm,
        ));
    }


    public function addProductAction(Request $request)
    {
        $error = $this->get('adding.product')->updateProducts();
        if (!$error){
            return new Response('Undetermined error');
        }
        return $this->render('ShopBundle:Default:index.html.twig');
    }

}
