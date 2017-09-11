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

        $allcategories = $this->get('doctrine.orm.entity_manager')
            ->getRepository(Categories::class)
            ->findAll();

        $paginator = $this->get('knp_paginator');
        $categoriesPagination = $paginator->paginate(
            $allcategories, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $this->container->getParameter('page_limit')
        );

        $vm = $this->get('shop.categories_view_model_assembler')->generateViewModel($categoriesPagination);

        return $this->render('ShopBundle:products:index.html.twig', array(
            'vm' => $vm,
        ));
    }

    public function showCategoryAction(Request $request, Categories $categories)
    {
        $this->get('thormeier_breadcrumb.breadcrumb_provider')
            ->getBreadcrumbByRoute('products_category')
            ->setRouteParameters(array(
                'slug' => $categories->getSlug(),
            ))
            ->setLabelParameters(array(
                'name' => $categories->getTitle(),
            ));

        $categoryiterms = $this->get('doctrine')
            ->getManager()
            ->getRepository(Products::class)
            ->findBy(['category' => $categories->getId()]);


        $paginator = $this->get('knp_paginator');
        $productsPagination = $paginator->paginate(
            $categoryiterms, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $this->container->getParameter('page_limit')
        );
        $vm = $this->get('shop.product_view_model_assembler')->generateViewModel($productsPagination);

        return $this->render('ShopBundle:products:category.html.twig', array(
                'vm' => $vm,
                'category' => $categories,
            )
        );
    }

    public function showSingleAction(Request $request, Products $products)
    {

        $this->get('thormeier_breadcrumb.breadcrumb_provider')
            ->getBreadcrumbByRoute('products_category')
            ->setRouteParameters(array(
                'slug' => $products->getCategory()->getSlug(),
            ))
            ->setLabelParameters(array(
                'name' => $products->getCategory()->getTitle(),
            ));
        $this->get('thormeier_breadcrumb.breadcrumb_provider')
            ->getBreadcrumbByRoute('products_show')
            ->setRouteParameters(array(
                'slug2' => $products->getCategory()->getSlug(),
                'slug' => $products->getSlug(),
            ))
            ->setLabelParameters(array(
                'name' => $products->getTitle(),
            ));

        $relproduct = $this->get('doctrine')
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
