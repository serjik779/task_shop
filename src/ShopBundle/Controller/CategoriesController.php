<?php

namespace ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ShopBundle\Entity\Categories;
use ShopBundle\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class CategoriesController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $model = $this->get('doctrine')->getManager()->getRepository(Categories::class)->findAll();
        $vm = $this->get('shop.allcategories_view_model_assembler')->generateViewModel($model);

        $paginator  = $this->get('knp_paginator');
        $categoriesPagination = $paginator->paginate(
            $model, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $this->container->getParameter('page_limit')
        );
        return $this->render('ShopBundle:categories:index.html.twig' , array(
            'vm' => $vm,
            'category' => $categoriesPagination
        ));
    }

    /**
     * @Template()
     */
    public function showProductsAction(Request $request, Categories $categories)
    {
        $model = $this->get('doctrine')->getManager()->getRepository(Products::class)->findBy(['category' => $request->get('id')]);
        $vm = $this->get('shop.categoryproduct_view_model_assembler')->generateViewModel($model);

        $paginator = $this->get('knp_paginator');
        $productsPagination = $paginator->paginate(
            $model, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $this->container->getParameter('page_limit')
        );
        return $this->render('ShopBundle:products:index.html.twig'
           , array(
                'vm' => $vm,
                'product' => $productsPagination,
                'category'=>$categories,
                )
        );
    }

}

