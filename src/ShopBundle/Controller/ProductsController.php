<?php

namespace ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ShopBundle\Entity\Categories;
use ShopBundle\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProductsController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $model = $this->get('doctrine')->getManager()->getRepository(Categories::class)->findAll();
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

    /**
     * @Template()
     */
    public function showCategoryAction(Request $request, Categories $categories)
    {
        $model = $this->get('doctrine')->getManager()->getRepository(Products::class)->findBy(['category' => $categories->getId()]);
        $vm = $this->get('shop.product_view_model_assembler')->generateViewModel($model);

        $paginator = $this->get('knp_paginator');
        $productsPagination = $paginator->paginate(
            $model, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $this->container->getParameter('page_limit')
        );
        return $this->render('ShopBundle:products:category.html.twig'
            , array(
                'vm' => $vm,
                'product' => $productsPagination,
                'category' => $categories,
            )
        );
    }

    /**
     * @Template()
     */
    public function showSingleAction(Request $request, Products $products)
    {
        $model = $this->get('doctrine')->getManager()->getRepository(Products::class)->findBy(['category' => $products->getCategory()->getId()], [], 10);
        $vm = $this->get('shop.relprod_view_model_assembler')->generateViewModel($model);

        return $this->render('ShopBundle:products:single.html.twig', array
        (
            'product' => $products,
            'vm' => $vm,
        ));
    }

}
