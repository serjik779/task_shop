<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Categories;
use ShopBundle\Entity\Images;
use ShopBundle\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProductsController extends Controller
{
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

    public function addProductAction(Request $request)
    {

        $responseJson = $this->get('data_center')->getData($request);
        $productsArray = json_decode($responseJson, true);
        $em = $this->get('doctrine.orm.default_entity_manager');
        for ($index = 0; $index < count($productsArray); $index ++) {
            $categoryById = $em->getRepository(Categories::class)->findOneBy(['id' => $productsArray[$index]['id']]);
            if ($categoryById == null ) {
                $categoryById = new Categories();
                $imageOfCategory = new Images();
                $imageOfCategory->setFilename($productsArray[$index]['image'])
                                ->refreshUpdated();
                $categoryById->setId($productsArray[$index]['id'])
                    ->setTitle($productsArray[$index]['title'])
                    ->setImage($imageOfCategory);
                $em->persist($imageOfCategory);
                $em->persist($categoryById);
                $em->flush();
            }
            for ($key = 0; $key < count($productsArray[$index]['products_in_category']); $key ++) {
                $productById = $em->getRepository(Products::class)->findOneBy(['id' => $productsArray[$index]['products_in_category'][$key]['id']]);
                if ($productById == null) {
                    $productById = new Products();
                    $imageOfProduct = new Images();
                    $imageOfProduct->setFilename($productsArray[$index]['products_in_category'][$key]['image_name'])
                                   ->refreshUpdated();
                    $productById->setId($productsArray[$index]['products_in_category'][$key]['id'])
                        ->setCategory($categoryById)
                        ->setTitle($productsArray[$index]['products_in_category'][$key]['title'])
                        ->setDescription($productsArray[$index]['products_in_category'][$key]['description'])
                        ->setCost($productsArray[$index]['products_in_category'][$key]['cost'])
                        ->setServiceId(1)
                        ->addImage($imageOfProduct);

                    $em->persist($productById);
                    $em->persist($imageOfProduct);
                    $em->flush();
                }
            }
        }
    }
}
