<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ShopBundle:home:index.html.twig');
    }

    public function contactVendorAction()
    {
        return $this->render('ShopBundle:Default:contactVendor.html.twig', array(
            'navigation_active' => 'others',
        ));
    }
}
