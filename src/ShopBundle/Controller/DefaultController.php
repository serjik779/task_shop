<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Brands;
use ShopBundle\Entity\Products;
use ShopBundle\Entity\Slider;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {

        $model1 = $this->get('doctrine')
            ->getManager()
            ->getRepository(Products::class)
            ->findBy(array('onMain' => 1, 'isVisible' => 1)); //product slider
        $model2 = $this->get('doctrine')
            ->getManager()
            ->getRepository(Products::class)
            ->findBy(array('onMain' => 1), ['created' => 'DESC'], 10); //latest products
        $model3 = $this->get('doctrine')
            ->getManager()
            ->getRepository(Products::class)
            ->findBy(array('top' => 1), [], 4); //top sellers
        $model4 = $this->get('doctrine')
            ->getManager()
            ->getRepository(Products::class)
            ->findBy(array('top' => 1), ['created' => 'DESC'], 4); //top new products
        $model5 = $this->get('doctrine')
            ->getManager()
            ->getRepository(Brands::class)
            ->findAll(); //brands
        $model6 = $this->get('doctrine')
            ->getManager()
            ->getRepository(Slider::class)
            ->findAll();

        $vm = $this->get('shop.index_view_model_assembler')
            ->generateViewModel($model1, $model2, $model3, $model4, $model5, $model6);

        return $this->render('ShopBundle:home:index.html.twig', array
        (
            'vm' => $vm,
        ));
    }
}


