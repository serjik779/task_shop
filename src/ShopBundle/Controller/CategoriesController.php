<?php
namespace ShopBundle\Controller;
use ShopBundle\Entity\Categories;
use ShopBundle\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
class CategoriesController extends Controller
{
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        #$categoriesRep = $this->getDoctrine()->getRepository(Categories::class);
        $categories = $em->getRepository(Categories::class)->findAll();
        $paginator  = $this->get('knp_paginator');
        $categoriesPagination = $paginator->paginate(
            $categories,
            $request->query->getInt('page', 1),
            $this->container->getParameter('page_limit')
        );
        return $this->render('ShopBundle:categories:index.html.twig', array(
            'categories' => $categoriesPagination,
        ));
    }
    public function showProductsAction(Request $request, Categories $category) {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository(Products::class)->findBy(['category' => $request->get('id')]);
        $paginator  = $this->get('knp_paginator');
        $productsPagination = $paginator->paginate(
            $products, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $this->container->getParameter('page_limit')
        );
        return $this->render('ShopBundle:products:index.html.twig', array(
            'products' => $productsPagination,
            'category' => $category
        ));
    }
}