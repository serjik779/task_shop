<?php

namespace ShopBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CartController extends Controller
{
    public function indexAction() {

//        dump($this->getRequest());
        dump($this->getRequest()->get('id'));
        die;
//        new JsonResponse()


        return $this->render('ShopBundle:cart:cart.html.twig');
    }

}
