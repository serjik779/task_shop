<?php


namespace ShopBundle\Controller;

use ShopBundle\Entity\Pages;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AboutController extends Controller
{
    public function aboutAction()
    {
         $em = $this->getDoctrine()->getManager();
         $page = $em->getRepository(Pages::class)->findOneBy(['title' => 'about']);
         return $this->render('ShopBundle:Static:about.html.twig', array(
             'navigator_active' => 'others',
             'page' => $page
         ));
    }
}