<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Categories;
use ShopBundle\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $model1 = $this->get('doctrine')->getManager()->
        getRepository(Products::class)->findBy(array('onMain' => 1, 'isVisible' => 1));
        $model2 = $this->get('doctrine')->getManager()->
        getRepository(Products::class)->findBy([], ['created' => 'DESC'], 10);
        $model3 = $this->get('doctrine')->getManager()->
        getRepository(Products::class)->findBy(array('top' => 1), [], 4);
        $model4 = $this->get('doctrine')->getManager()->
        getRepository(Products::class)->findBy(array('top' => 1), ['created' => 'DESC'], 4);
        $model5 = $this->get('doctrine')->getManager()->getRepository(Categories::class)->findAll();

        $vm = $this->get('shop.index_view_model_assembler')->generateViewModel($model1, $model2, $model3, $model4, $model5);

        return $this->render('ShopBundle:home:index.html.twig', array
        (
            'vm' => $vm,
        ));
    }
}
