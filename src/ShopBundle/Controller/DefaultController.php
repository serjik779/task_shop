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

        $slider = $this->get('doctrine')
            ->getManager()
            ->getRepository(Slider::class)
            ->findAll();
        $latestproducts = $this->get('doctrine')
            ->getManager()
            ->getRepository(Products::class)
            ->findBy(array('onMain' => 1), ['created' => 'DESC'], $this->getParameter('lastest products limit'));
        $topsellers = $this->get('doctrine')
            ->getManager()
            ->getRepository(Products::class)
            ->findBy(array('top' => 1), [], $this->getParameter('top block limit'));
        $topnew = $this->get('doctrine')
            ->getManager()
            ->getRepository(Products::class)
            ->findBy(array('top' => 1), ['created' => 'DESC'], $this->getParameter('top block limit'));
        $brands = $this->get('doctrine')
            ->getManager()
            ->getRepository(Brands::class)
            ->findAll();

        $vm = $this->get('shop.index_view_model_assembler')
            ->generateViewModel($slider, $latestproducts, $topsellers, $topnew, $brands);

        return $this->render('ShopBundle:home:index.html.twig', array
        (
            'vm' => $vm,
        ));
    }
}


