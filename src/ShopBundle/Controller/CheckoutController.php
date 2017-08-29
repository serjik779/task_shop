<?php

namespace ShopBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CheckoutController extends Controller
{
    public function indexAction() {
        return $this->render('ShopBundle:checkout:checkout.html.twig');
    }

}
