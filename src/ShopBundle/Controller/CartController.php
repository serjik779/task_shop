<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\cart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CartController extends Controller
{
    public function indexAction() {
        return $this->render('ShopBundle:Cart:cart.html.twig');
    }

}
