<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    public function indexAction()
    {
        $model = $this->get('doctrine')->getManager()->
        getRepository(Products::class)->findBy(array('onMain' => 1, 'isVisible' => 1));
        $vm = $this->get('shop.index_view_model_assembler')->generateViewModel($model);

        return $this->render('ShopBundle:home:index.html.twig', array
        (
            'vm' => $vm,
        ));
    }
}
